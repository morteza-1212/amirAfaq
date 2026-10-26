<?php

namespace App\service;

use App\Models\Faq;
use App\Models\FaqTranslation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FaqSearchService
{
    private const SIMILARITY_THRESHOLD = 0.25;
    private const CACHE_TTL = 600;

    public function findBestAnswer(string $message, string $locale = 'fa'): ?Faq
    {
        $normalized = $this->normalize($message);

        Log::info('[FaqSearch] searching', [
            'query'    => $message,
            'normalized' => $normalized,
            'locale'   => $locale,
        ]);

        if ($normalized === '') {
            return null;
        }

        // ۱. جستجوی exact
        $exact = $this->searchExact($normalized, $locale);
        if ($exact) {
            Log::info('[FaqSearch] exact match', ['faq_id' => $exact->id]);
            return $exact;
        }

        // ۲. جستجوی شبیه
        $similar = $this->searchSimilar($normalized, $locale);
        if ($similar) {
            Log::info('[FaqSearch] similar match', ['faq_id' => $similar->id]);
        } else {
            Log::info('[FaqSearch] NO match found');
        }
        return $similar;
    }

    private function searchExact(string $normalized, string $locale): ?Faq
    {
        return Faq::query()
            ->where('is_active', true)
            ->whereHas('translations', function ($q) use ($normalized, $locale) {
                $q->where('locale', $locale)
                    ->whereRaw('LOWER(question) LIKE ?', ["%{$normalized}%"]);
            })
            ->with(['translations' => fn ($q) => $q->where('locale', $locale)])
            ->orderBy('sort_order')
            ->first();
    }

    private function searchSimilar(string $normalized, string $locale): ?Faq
    {
        // ✅ فقط داده‌های ساده (آرایه) را کش می‌کنیم، نه آبجکت مدل
        $candidates = Cache::remember(
            "faq_trans_{$locale}_v4",
            self::CACHE_TTL,
            function () use ($locale) {
                return FaqTranslation::query()
                    ->where('locale', $locale)
                    ->whereHas('faq', fn ($q) => $q->where('is_active', true))
                    ->with('faq')
                    ->get()
                    ->map(function (FaqTranslation $t) {
                        return [
                            'faq_id'    => $t->faq_id,
                            'question'  => $t->question,
                            'keywords'  => $t->keywords,
                            'faq_answer'=> $t->faq?->answer,
                        ];
                    })
                    ->all();
            }
        );

        Log::info('[FaqSearch] candidates', ['count' => count($candidates)]);

        $bestId = null;
        $bestScore = 0.0;

        foreach ($candidates as $candidate) {
            if (empty($candidate['faq_id'])) {
                continue;
            }

            $question = $this->normalize($candidate['question']);

            similar_text($normalized, $question, $percent);
            $score = $percent / 100;

            // پاداش کلمات کلیدی
            $keywords = $candidate['keywords'];
            if (is_string($keywords)) {
                $keywords = json_decode($keywords, true) ?: [];
            }
            if (is_array($keywords) && !empty($keywords)) {
                $kwScore = $this->keywordScore($normalized, $keywords);
                $score = max($score, $kwScore);
            }

            Log::info('[FaqSearch] score', [
                'faq_id'   => $candidate['faq_id'],
                'question' => $candidate['question'],
                'score'    => round($score, 3),
            ]);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestId = $candidate['faq_id'];
            }
        }

        Log::info('[FaqSearch] best', [
            'faq_id' => $bestId,
            'score'  => round($bestScore, 3),
            'threshold' => self::SIMILARITY_THRESHOLD,
        ]);

        if ($bestScore < self::SIMILARITY_THRESHOLD || $bestId === null) {
            return null;
        }

        // ✅ فقط در صورت نیاز، مدل کامل را از دیتابیس می‌خوانیم
        return Faq::with(['translations' => fn ($q) => $q->where('locale', $locale)])
            ->find($bestId);
    }

    private function keywordScore(string $normalized, array $keywords): float
    {
        $queryWords = array_filter(explode(' ', $normalized));
        if (empty($queryWords)) {
            return 0.0;
        }

        $matched = 0;
        foreach ($keywords as $keyword) {
            $keyword = $this->normalize((string) $keyword);
            if ($keyword === '') continue;

            // اگر کلمه کلیدی در جمله کاربر باشد
            if (in_array($keyword, $queryWords, true)) {
                $matched++;
            } elseif (mb_strpos($normalized, $keyword) !== false) {
                // یا به صورت زیررشته
                $matched += 0.8;
            }
        }

        // نرمال‌سازی: نسبت کلمات کلیدی مطابق به کلمات کلیدی
        $total = max(count($keywords), 1);
        return min(1.0, ($matched / $total) * 1.2);
    }

    private function normalize(string $text): string
    {
        $text = strip_tags($text);
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return mb_strtolower(trim($text));
    }
}
