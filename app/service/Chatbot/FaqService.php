<?php

namespace App\service\Chatbot;

use App\Models\Faq;
use Illuminate\Support\Str;

class FaqService
{
    /**
     * جست‌وجوی پاسخ مناسب در سؤالات متداول.
     *
     * @param string $question
     * @param string $locale
     * @return array|null
     */
    public function findAnswer(
        string $question,
        string $locale = 'fa'
    ): ?array {
        $question = $this->normalizeText($question);

        if ($question === '') {
            return null;
        }

        // دریافت FAQهای فعال با ترجمه زبان موردنظر
        $faqs = Faq::query()
            ->where('is_active', true)
            ->whereHas('translations', function ($query) use ($locale) {
                $query->where('locale', $locale);
            })
            ->with([
                'translations' => function ($query) use ($locale) {
                    $query->where('locale', $locale);
                }
            ])
            ->get();

        $bestFaq = null;
        $bestScore = 0;

        foreach ($faqs as $faq) {
            $translation = $faq->translations->first();

            if (!$translation) {
                continue;
            }

            $faqQuestion = $this->normalizeText(
                $translation->question ?? ''
            );

            if ($faqQuestion === '') {
                continue;
            }

            $score = $this->calculateSimilarity(
                $question,
                $faqQuestion
            );

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestFaq = [
                    'faq_id' => $faq->id,
                    'question' => $translation->question,
                    'answer' => $translation->answer,
                    'locale' => $locale,
                    'score' => $score,
                    'source' => 'faq',
                ];
            }
        }

        // حداقل امتیاز لازم برای پذیرفتن پاسخ FAQ
        if ($bestFaq === null || $bestScore < 0.55) {
            return null;
        }

        return $bestFaq;
    }

    /**
     * محاسبه میزان شباهت دو متن.
     */
    private function calculateSimilarity(
        string $question,
        string $faqQuestion
    ): float {
        // تطبیق کامل یا وجود یکی از عبارت‌ها در دیگری
        if ($question === $faqQuestion) {
            return 1.0;
        }

        if (
            Str::contains($faqQuestion, $question) ||
            Str::contains($question, $faqQuestion)
        ) {
            return 0.85;
        }

        $questionWords = $this->getWords($question);
        $faqWords = $this->getWords($faqQuestion);

        if (empty($questionWords) || empty($faqWords)) {
            return 0.0;
        }

        $commonWords = array_intersect(
            $questionWords,
            $faqWords
        );

        $score = count($commonWords) / count(
                array_unique(array_merge($questionWords, $faqWords))
            );

        return $score;
    }

    /**
     * نرمال‌سازی متن فارسی، انگلیسی و عربی.
     */
    private function normalizeText(string $text): string
    {
        $text = mb_strtolower(trim($text), 'UTF-8');

        // یکسان‌سازی حروف عربی و فارسی
        $text = str_replace(
            ['ي', 'ى', 'ك', 'أ', 'إ', 'آ', 'ة'],
            ['ی', 'ی', 'ک', 'ا', 'ا', 'ا', 'ه'],
            $text
        );

        // حذف اعراب عربی
        $text = preg_replace(
            '/[\x{064B}-\x{065F}\x{0670}]/u',
            '',
            $text
        );

        // تبدیل علائم نگارشی به فاصله
        $text = preg_replace(
            '/[^\p{L}\p{N}\s]/u',
            ' ',
            $text
        );

        // حذف فاصله‌های اضافی
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }

    /**
     * استخراج کلمات متن.
     */
    private function getWords(string $text): array
    {
        $words = preg_split('/\s+/u', $text);

        // حذف کلمات کوتاه و تکراری
        $words = array_filter($words, function ($word) {
            return mb_strlen($word, 'UTF-8') >= 2;
        });

        return array_values(array_unique($words));
    }
}
