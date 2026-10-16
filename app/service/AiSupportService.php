<?php

namespace App\service;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Faq;
use Illuminate\Support\Facades\Cache;

class AiSupportService
{
    /**
     * @var array لیست کلمات توقف برای نرمال‌سازی
     */
    private array $stopWords = [
        'سلام', 'خوب', 'ممنون', 'لطفاً', 'بله', 'خیر',
        'چطور', 'چگونه', 'میخوام', 'میشه', 'باشه', 'نه',
        'آره', 'اوکی', 'باش', 'خواهش', 'مرسی'
    ];

    /**
     * @var float آستانه شباهت برای تشخیص سوال مشابه
     */
    private float $similarityThreshold = 0.3;

    /**
     * @var int حداکثر تعداد کلمات برای تشخیص سوال پیچیده
     */
    private int $complexQuestionWordLimit = 20;

    /**
     * پاسخ به سوال کاربر با استفاده از FAQ و AI
     */
    public function answer(string $customerMessage): array
    {
        try {
            // ۱. نرمال‌سازی پیام کاربر
            $normalizedMessage = $this->normalizeText($customerMessage);

            // ۲. جستجو در FAQ
            $faqResult = $this->searchInFaq($normalizedMessage);

            // ۳. اگر سوال در FAQ پیدا شد
            if ($faqResult['found']) {
                return [
                    'answer' => $faqResult['answer'],
                    'needs_human' => false,
                    'faq_id' => $faqResult['faq_id'],
                    'category' => $faqResult['category'],
                    'confidence' => $faqResult['confidence'],
                    'source' => 'faq',
                ];
            }

            // ۴. بررسی نیاز به اپراتور انسانی
            if ($this->needsHumanSupport($normalizedMessage)) {
                return [
                    'answer' => $this->getTransferMessage(),
                    'needs_human' => true,
                    'reason' => 'complex_question',
                    'source' => 'system',
                ];
            }

            // ۵. استفاده از AI (Claude) برای پاسخ
            $aiResult = $this->askAI($customerMessage);

            // ۶. اگر AI تشخیص داد نیاز به اپراتور دارد
            if ($aiResult['needs_human'] ?? false) {
                return [
                    'answer' => $this->getTransferMessage(),
                    'needs_human' => true,
                    'reason' => 'ai_detected',
                    'source' => 'ai',
                ];
            }

            // ۷. پاسخ AI
            if (!empty($aiResult['answer'])) {
                return [
                    'answer' => $aiResult['answer'],
                    'needs_human' => false,
                    'source' => 'ai',
                    'confidence' => $aiResult['confidence'] ?? 50,
                ];
            }

            // ۸. پاسخ پیش‌فرض با پیشنهاد سوالات پرتکرار
            return $this->getFallbackResponse();

        } catch (\Exception $e) {
            Log::error('Error in AiSupportService@answer: ' . $e->getMessage(), [
                'message' => $customerMessage,
                'trace' => $e->getTraceAsString()
            ]);

            // در صورت خطا، پیشنهاد ارتباط با اپراتور
            return [
                'answer' => "⚠️ سیستم پاسخگویی موقتاً در دسترس نیست.\n\n" .
                    "لطفاً دوباره تلاش کنید یا از طریق شماره ۰۹۱۵۷۱۱۸۵۶۵ با پشتیبانی تماس بگیرید.",
                'needs_human' => true,
                'source' => 'error',
            ];
        }
    }

    /**
     * جستجو در FAQ
     */
    private function searchInFaq(string $query): array
    {
        try {
            // ۱. جستجوی دقیق
            $exactMatch = Faq::where('question', 'like', "%{$query}%")
                ->where('is_active', true)
                ->orderBy('priority', 'desc')
                ->orderBy('usage_count', 'desc')
                ->first();

            if ($exactMatch) {
                $exactMatch->incrementUsage();
                return [
                    'found' => true,
                    'answer' => $exactMatch->answer,
                    'faq_id' => $exactMatch->id,
                    'category' => $exactMatch->category,
                    'confidence' => 95,
                ];
            }

            // ۲. جستجوی با شباهت
            $allFaqs = Faq::where('is_active', true)->get();
            $bestMatch = null;
            $bestScore = 0;

            foreach ($allFaqs as $faq) {
                $score = $this->calculateSimilarity($query, $faq->question);

                // افزایش امتیاز برای کلمات کلیدی
                if ($faq->keywords) {
                    $keywordScore = $this->checkKeywords($query, $faq->keywords);
                    $score = max($score, $keywordScore * 0.8);
                }

                if ($score > $bestScore && $score > $this->similarityThreshold) {
                    $bestScore = $score;
                    $bestMatch = $faq;
                }
            }

            if ($bestMatch) {
                $bestMatch->incrementUsage();
                return [
                    'found' => true,
                    'answer' => $bestMatch->answer,
                    'faq_id' => $bestMatch->id,
                    'category' => $bestMatch->category,
                    'confidence' => round($bestScore * 100, 2),
                ];
            }

            return ['found' => false];

        } catch (\Exception $e) {
            Log::error('Error in searchInFaq: ' . $e->getMessage());
            return ['found' => false];
        }
    }

    /**
     * استفاده از AI (Claude) برای پاسخ
     */
    private function askAI(string $message): array
    {
        try {
            // دریافت FAQ ها برای System Prompt
            $faqs = Faq::where('is_active', true)
                ->orderBy('priority', 'desc')
                ->limit(50)
                ->get();

            $faqText = $faqs->map(function ($f) {
                return "Q: {$f->question}\nA: {$f->answer}";
            })->implode("\n\n");

            $systemPrompt = <<<PROMPT
تو دستیار پشتیبانی یک فروشگاه لباس کودک و نوجوان به نام "جوجه رنگی" هستی.

قوانین پاسخگویی:
1. فقط بر اساس دانش زیر جواب بده.
2. اگر جواب سوال در این دانش نبود، دقیقاً همین رشته را برگردان: "NEED_HUMAN_SUPPORT"
3. پاسخ‌ها باید کوتاه، مفید و دوستانه باشند.
4. از ایموجی‌های مناسب استفاده کن (🧸، 👕، 🎁، 💝)

دانش فروشگاه:
{$faqText}

اگر سوال مربوط به موارد زیر بود، حتماً "NEED_HUMAN_SUPPORT" برگردان:
- شکایت یا مشکل خاص
- خرابی محصول
- مسائل مالی و پرداخت
- خرید عمده
- مشاوره تخصصی

هیچ چیز دیگری غیر از پاسخ یا "NEED_HUMAN_SUPPORT" ننویس.
PROMPT;

            $apiKey = config('services.anthropic.key');

            if (empty($apiKey)) {
                Log::warning('Anthropic API key is not configured');
                return ['needs_human' => true, 'answer' => null];
            }

            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])->timeout(15)->post('https://api.anthropic.com/v1/messages', [
                'model' => 'claude-3-sonnet-20240229',
                'max_tokens' => 500,
                'temperature' => 0.3,
                'system' => $systemPrompt,
                'messages' => [
                    ['role' => 'user', 'content' => $message],
                ],
            ]);

            if (!$response->successful()) {
                Log::error('AI API error: ' . $response->body());
                return ['needs_human' => true, 'answer' => null];
            }

            $data = $response->json();
            $text = $data['content'][0]['text'] ?? 'NEED_HUMAN_SUPPORT';

            // اگر AI تشخیص داد نیاز به اپراتور دارد
            if (trim($text) === 'NEED_HUMAN_SUPPORT') {
                return ['needs_human' => true, 'answer' => null];
            }

            return [
                'answer' => $text,
                'needs_human' => false,
                'confidence' => 70,
            ];

        } catch (\Exception $e) {
            Log::error('AI request failed: ' . $e->getMessage());
            return ['needs_human' => true, 'answer' => null];
        }
    }

    /**
     * تشخیص نیاز به اپراتور انسانی
     */
    private function needsHumanSupport(string $message): bool
    {
        // الگوهای کلمات کلیدی برای تشخیص نیاز به اپراتور
        $patterns = [
            '/شکایت|خرابی|عیب|مشکل/i',
            '/پشتیبانی فوری|فوری|اضطراری/i',
            '/خرید عمده|تخفیف ویژه|قیمت عمده/i',
            '/مشاوره|راهنمایی تخصصی/i',
            '/بازگشت پول|پول برگشت|استرداد/i',
            '/گم شدن|دزدیده|آسیب دیده/i',
            '/حالت|خواهش|لطفاً کمک/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message)) {
                return true;
            }
        }

        // اگر سوال طولانی باشد (بیش از 20 کلمه)
        $wordCount = str_word_count($message);
        if ($wordCount > $this->complexQuestionWordLimit) {
            return true;
        }

        return false;
    }

    /**
     * محاسبه شباهت بین دو متن
     */
    private function calculateSimilarity(string $text1, string $text2): float
    {
        $text1 = $this->normalizeText($text1);
        $text2 = $this->normalizeText($text2);

        if (empty($text1) || empty($text2)) {
            return 0;
        }

        similar_text($text1, $text2, $percent);
        return $percent / 100;
    }

    /**
     * بررسی کلمات کلیدی در متن
     */
    private function checkKeywords(string $text, array $keywords): float
    {
        $text = $this->normalizeText($text);
        $textWords = explode(' ', $text);

        $matched = 0;
        foreach ($keywords as $keyword) {
            $keyword = $this->normalizeText($keyword);
            if (in_array($keyword, $textWords)) {
                $matched++;
            }
        }

        return count($textWords) > 0 ? $matched / count($textWords) : 0;
    }

    /**
     * نرمال‌سازی متن
     */
    private function normalizeText(string $text): string
    {
        // حذف تگ‌ها
        $text = strip_tags($text);

        // حذف علائم نگارشی
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);

        // حذف فاصله‌های اضافی
        $text = preg_replace('/\s+/', ' ', $text);

        // تبدیل به حروف کوچک
        return mb_strtolower(trim($text));
    }

    /**
     * پیام انتقال به اپراتور
     */
    private function getTransferMessage(): string
    {
        return "🔴 **سوال شما تخصصی است و نیاز به بررسی کارشناس دارد.**\n\n" .
            "🔄 در حال انتقال شما به پشتیبانی انسانی...\n" .
            "⏳ لطفاً چند لحظه صبر کنید. 🙏\n\n" .
            "💬 به محض اتصال، پیام شما در اختیار اپراتور قرار خواهد گرفت.\n" .
            "📞 در صورت فوریت با شماره ۰۹۱۵۷۱۱۸۵۶۵ تماس بگیرید.";
    }

    /**
     * پاسخ پیش‌فرض با پیشنهاد سوالات پرتکرار
     */
    private function getFallbackResponse(): array
    {
        $popularFaqs = Faq::where('is_active', true)
            ->orderBy('usage_count', 'desc')
            ->orderBy('priority', 'desc')
            ->limit(5)
            ->get();

        if ($popularFaqs->isEmpty()) {
            return [
                'answer' => "🙂 متأسفم، پاسخ سوال شما را پیدا نکردم.\n\n" .
                    "💡 لطفاً سوال خود را دقیق‌تر بپرسید یا با پشتیبانی تماس بگیرید.\n" .
                    "📞 شماره تماس: ۰۹۱۵۷۱۱۸۵۶۵",
                'needs_human' => false,
                'source' => 'fallback',
            ];
        }

        $suggestions = "📌 **سوالات پرتکرار:**\n\n";
        foreach ($popularFaqs as $index => $faq) {
            $suggestions .= ($index + 1) . ". " . $faq->question . "\n";
        }

        return [
            'answer' => "🙂 متأسفم، پاسخ سوال شما را پیدا نکردم.\n\n" .
                $suggestions .
                "\n\n💡 اگر سوال شما در لیست بالا نیست، لطفاً آن را دقیق‌تر بپرسید یا با پشتیبانی تماس بگیرید.\n" .
                "📞 شماره تماس: ۰۹۱۵۷۱۱۸۵۶۵",
            'needs_human' => false,
            'source' => 'fallback',
        ];
    }

    /**
     * دریافت پاسخ از FAQ بر اساس ID
     */
    public function getAnswerById(int $faqId): ?string
    {
        $faq = Faq::find($faqId);
        if ($faq && $faq->is_active) {
            $faq->incrementUsage();
            return $faq->answer;
        }
        return null;
    }

    /**
     * جستجوی پیشرفته در FAQ
     */
    public function search(string $query): array
    {
        $results = [];

        // جستجوی دقیق
        $exactMatches = Faq::where('question', 'like', "%{$query}%")
            ->where('is_active', true)
            ->orderBy('priority', 'desc')
            ->orderBy('usage_count', 'desc')
            ->limit(5)
            ->get();

        foreach ($exactMatches as $match) {
            $results[] = [
                'id' => $match->id,
                'question' => $match->question,
                'answer' => $match->answer,
                'category' => $match->category,
                'score' => 100,
                'type' => 'exact',
            ];
        }

        // جستجوی با شباهت
        $allFaqs = Faq::where('is_active', true)
            ->whereNotIn('id', $exactMatches->pluck('id'))
            ->get();

        foreach ($allFaqs as $faq) {
            $score = $this->calculateSimilarity($query, $faq->question);

            if ($faq->keywords) {
                $keywordScore = $this->checkKeywords($query, $faq->keywords);
                $score = max($score, $keywordScore * 0.8);
            }

            if ($score > $this->similarityThreshold) {
                $results[] = [
                    'id' => $faq->id,
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                    'category' => $faq->category,
                    'score' => round($score * 100, 2),
                    'type' => 'similar',
                ];
            }
        }

        // مرتب‌سازی بر اساس امتیاز
        usort($results, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return array_slice($results, 0, 10);
    }

    /**
     * دریافت آمار استفاده از FAQ
     */
    public function getStatistics(): array
    {
        $cacheKey = 'faq_statistics';

        return Cache::remember($cacheKey, 3600, function () {
            return [
                'total' => Faq::count(),
                'active' => Faq::where('is_active', true)->count(),
                'inactive' => Faq::where('is_active', false)->count(),
                'most_used' => Faq::where('is_active', true)
                    ->orderBy('usage_count', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($faq) {
                        return [
                            'id' => $faq->id,
                            'question' => $faq->question,
                            'usage_count' => $faq->usage_count,
                        ];
                    })
                    ->toArray(),
                'categories' => Faq::select('category')
                    ->whereNotNull('category')
                    ->where('is_active', true)
                    ->distinct()
                    ->pluck('category')
                    ->toArray(),
                'total_usage' => Faq::sum('usage_count'),
            ];
        });
    }

    /**
     * پاک کردن کش آمار
     */
    public function clearStatisticsCache(): void
    {
        Cache::forget('faq_statistics');
    }

    /**
     * پیشنهاد سوالات بر اساس کلمات کلیدی
     */
    public function suggestQuestions(string $query, int $limit = 5): array
    {
        $suggestions = [];

        $faqs = Faq::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('question', 'like', "%{$query}%")
                    ->orWhere('keywords', 'like', "%{$query}%");
            })
            ->orderBy('priority', 'desc')
            ->orderBy('usage_count', 'desc')
            ->limit($limit)
            ->get();

        foreach ($faqs as $faq) {
            $suggestions[] = [
                'id' => $faq->id,
                'question' => $faq->question,
                'category' => $faq->category,
            ];
        }

        return $suggestions;
    }
}
