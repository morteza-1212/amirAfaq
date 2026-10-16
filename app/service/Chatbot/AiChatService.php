<?php

namespace App\service\Chatbot;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class AiChatService
{
    public function __construct(
        protected FaqService $faqService
    ) {
    }

    /**
     * تولید پاسخ برای کاربر.
     *
     * @param string $message
     * @param string $locale
     * @param array $history
     * @return array
     */
    public function answer(
        string $message,
        string $locale = 'fa',
        array $history = []
    ): array {
        $message = trim($message);

        if ($message === '') {
            return [
                'answer' => $this->emptyMessage($locale),
                'needs_human' => false,
                'source' => 'system',
            ];
        }

        // 1. بررسی درخواست مستقیم برای ارتباط با کارشناس
        if ($this->wantsHumanAgent($message, $locale)) {
            return [
                'answer' => $this->handoffMessage($locale),
                'needs_human' => true,
                'source' => 'handoff',
            ];
        }

        // 2. جست‌وجو در FAQ
        $faqAnswer = $this->faqService->findAnswer(
            $message,
            $locale
        );

        if ($faqAnswer !== null) {
            return [
                'answer' => $faqAnswer['answer'],
                'needs_human' => false,
                'source' => 'faq',
                'faq_id' => $faqAnswer['faq_id'],
            ];
        }

        // 3. استفاده از هوش مصنوعی
        return $this->requestAiResponse(
            $message,
            $locale,
            $history
        );
    }

    /**
     * ارسال درخواست به API هوش مصنوعی.
     */
    private function requestAiResponse(
        string $message,
        string $locale,
        array $history = []
    ): array {
        $apiKey = config('services.openai.key');

        // اگر API تنظیم نشده باشد، پاسخ ساختگی تولید نمی‌کنیم.
        if (empty($apiKey)) {
            return [
                'answer' => $this->fallbackMessage($locale),
                'needs_human' => false,
                'source' => 'fallback',
            ];
        }

        $messages = [
            [
                'role' => 'system',
                'content' => $this->systemPrompt($locale),
            ],
        ];

        // افزودن تاریخچه محدود مکالمه
        foreach (array_slice($history, -10) as $item) {
            if (
                !isset($item['role'], $item['content']) ||
                !in_array($item['role'], ['user', 'assistant'], true)
            ) {
                continue;
            }

            $messages[] = [
                'role' => $item['role'],
                'content' => (string) $item['content'],
            ];
        }

        // سؤال فعلی کاربر
        $messages[] = [
            'role' => 'user',
            'content' => $message,
        ];

        try {
            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->asJson()
                ->timeout(30)
                ->post(
                    'https://api.openai.com/v1/chat/completions',
                    [
                        'model' => config(
                            'services.openai.model',
                            'gpt-4.1-mini'
                        ),
                        'messages' => $messages,
                        'temperature' => 0.3,
                    ]
                );

            if (!$response->successful()) {
                Log::warning('Chatbot AI API request failed', [
                    'status' => $response->status(),
                ]);

                return [
                    'answer' => $this->fallbackMessage($locale),
                    'needs_human' => false,
                    'source' => 'fallback',
                ];
            }

            $answer = trim(
                (string) $response->json(
                    'choices.0.message.content',
                    ''
                )
            );

            if ($answer === '') {
                return [
                    'answer' => $this->fallbackMessage($locale),
                    'needs_human' => false,
                    'source' => 'fallback',
                ];
            }

            return [
                'answer' => $answer,
                'needs_human' => false,
                'source' => 'ai',
            ];
        } catch (Throwable $exception) {
            Log::error('Chatbot AI request exception', [
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            return [
                'answer' => $this->fallbackMessage($locale),
                'needs_human' => false,
                'source' => 'fallback',
            ];
        }
    }

    /**
     * دستورالعمل اصلی هوش مصنوعی.
     */
    private function systemPrompt(string $locale): string
    {
        $language = match ($locale) {
            'en' => 'English',
            'ar' => 'Arabic',
            default => 'Persian',
        };

        return <<<PROMPT
You are the official AI assistant of Amir Afagh Gostar Pars,
an international import and export company.

Your responsibilities:
- Answer questions about the company's import and export services.
- Help users prepare inquiries about products, quantities,
  destination countries, destination ports, packaging,
  delivery schedules, Incoterms and payment terms.
- Ask concise follow-up questions when necessary.
- Help potential buyers and suppliers submit business inquiries.
- Recommend contacting a human specialist when the question
  requires company-specific confirmation.

Important rules:
- Always answer in {$language}.
- Never invent product availability, prices, quotations,
  shipping schedules, certificates, company capabilities,
  customs rules or contractual terms.
- If verified information is unavailable, clearly say that
  the information needs confirmation by a company specialist.
- Do not claim that a human agent has already been notified
  unless the application has actually completed that action.
- Do not request passwords, payment card details or other
  unnecessary sensitive information.
- Be professional, concise and helpful.
PROMPT;
    }

    /**
     * تشخیص درخواست ارتباط با کارشناس.
     */
    private function wantsHumanAgent(
        string $message,
        string $locale
    ): bool {
        $message = mb_strtolower($message, 'UTF-8');

        $patterns = [
            'fa' => [
                '/کارشناس/u',
                '/اپراتور/u',
                '/پشتیبان/u',
                '/صحبت با انسان/u',
                '/ارتباط با مسئول/u',
                '/وصل(?:م|کن|شو)? به (?:یک )?کارشناس/u',
            ],
            'en' => [
                '/human agent/i',
                '/talk to (a )?(human|person|specialist)/i',
                '/customer support/i',
                '/contact (an? )?(agent|specialist)/i',
                '/speak to (a )?(human|person|agent)/i',
            ],
            'ar' => [
                '/موظف/u',
                '/خدمة العملاء/u',
                '/التحدث مع شخص/u',
                '/التواصل مع مسؤول/u',
                '/التحدث مع موظف/u',
            ],
        ];

        foreach ($patterns[$locale] ?? $patterns['fa'] as $pattern) {
            if (preg_match($pattern, $message)) {
                return true;
            }
        }

        return false;
    }

    /**
     * پیام اطلاع‌رسانی درباره درخواست کارشناس.
     */
    private function handoffMessage(string $locale): string
    {
        return match ($locale) {
            'en' => 'Your request to speak with a company specialist has been recognized. I will register it for follow-up.',
            'ar' => 'تم التعرف على طلبك للتواصل مع أحد مختصي الشركة. سيتم تسجيل الطلب للمتابعة.',
            default => 'درخواست شما برای ارتباط با کارشناس شناسایی شد. درخواست را برای پیگیری ثبت می‌کنیم.',
        };
    }

    /**
     * پیام در صورت نبودن API یا بروز خطا.
     */
    private function fallbackMessage(string $locale): string
    {
        return match ($locale) {
            'en' => 'I could not retrieve a reliable answer right now. Please provide your product, quantity and destination country so the company team can review your inquiry.',
            'ar' => 'تعذر الحصول على إجابة موثوقة حالياً. يرجى تحديد المنتج والكمية وبلد الوجهة حتى يتمكن فريق الشركة من مراجعة طلبك.',
            default => 'در حال حاضر نتوانستم پاسخ قابل‌اعتمادی دریافت کنم. لطفاً محصول، مقدار موردنیاز و کشور مقصد را مشخص کنید تا درخواست شما برای بررسی دقیق‌تر آماده شود.',
        };
    }

    /**
     * پیام برای ورودی خالی.
     */
    private function emptyMessage(string $locale): string
    {
        return match ($locale) {
            'en' => 'Please enter your question.',
            'ar' => 'يرجى كتابة سؤالك.',
            default => 'لطفاً سؤال خود را وارد کنید.',
        };
    }
}
