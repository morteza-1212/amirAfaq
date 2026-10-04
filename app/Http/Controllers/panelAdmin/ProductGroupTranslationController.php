<?php

namespace App\Http\Controllers\PanelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductGroupTranslationRequest;
use App\Http\Requests\UpdateProductGroupTranslationRequest;
use App\Models\ProductGroup;
use App\Models\ProductGroupTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductGroupTranslationController extends Controller
{
    /**
     * نمایش ترجمه‌های یک گروه
     */
    public function index(ProductGroup $productGroup): View
    {
        $translations = $productGroup
            ->translations()
            ->orderByRaw("
                CASE locale
                    WHEN 'fa' THEN 1
                    WHEN 'en' THEN 2
                    WHEN 'ar' THEN 3
                    ELSE 4
                END
            ")
            ->paginate(10);

        return view(
            'panelAdmin.productTranslation.index',
            compact('productGroup', 'translations')
        );
    }

    /**
     * فرم ایجاد ترجمه
     */
    public function create(ProductGroup $productGroup): View
    {
        $usedLocales = $productGroup
            ->translations()
            ->pluck('locale')
            ->toArray();

        $availableLocales = collect([
            'fa' => 'فارسی',
            'en' => 'English',
            'ar' => 'العربية',
        ])->except($usedLocales);

        return view(
            'panelAdmin.productTranslation.create',
            compact(
                'productGroup',
                'availableLocales'
            )
        );
    }

    /**
     * ذخیره ترجمه
     */
    public function store(
        StoreProductGroupTranslationRequest $request,
        ProductGroup $productGroup
    ): RedirectResponse {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug(
                $data['name'],
                $data['locale']
            );
        } else {
            $data['slug'] = $this->generateUniqueSlug(
                $data['slug'],
                $data['locale']
            );
        }

        $productGroup->translations()->create($data);

        return redirect()
            ->route(
                'admin.productGroup.translations.index',
                $productGroup
            )
            ->with('success', 'ترجمه گروه محصول با موفقیت ایجاد شد.');
    }

    /**
     * نمایش ترجمه
     */
    public function show(
        ProductGroup $productGroup,
        ProductGroupTranslation $translation
    ): View {
        $this->ensureTranslationBelongsToGroup(
            $productGroup,
            $translation
        );

        return view(
            'panelAdmin.product-groups.translations.show',
            compact(
                'productGroup',
                'translation'
            )
        );
    }

    /**
     * فرم ویرایش
     */
    public function edit(
        ProductGroup $productGroup,
        ProductGroupTranslation $translation
    ): View {
        $this->ensureTranslationBelongsToGroup(
            $productGroup,
            $translation
        );

        return view(
            'panelAdmin.productTranslation.edit',
            compact(
                'productGroup',
                'translation'
            )
        );
    }

    /**
     * بروزرسانی
     */
    public function update(
        UpdateProductGroupTranslationRequest $request,
        ProductGroup $productGroup,
        ProductGroupTranslation $translation
    ): RedirectResponse {
        $this->ensureTranslationBelongsToGroup(
            $productGroup,
            $translation
        );

        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug(
                $data['name'],
                $data['locale'],
                $translation->id
            );
        } else {
            $data['slug'] = $this->generateUniqueSlug(
                $data['slug'],
                $data['locale'],
                $translation->id
            );
        }

        $translation->update($data);

        return redirect()
            ->route(
                'admin.productGroup.translations.index',
                $productGroup
            )
            ->with('success', 'ترجمه گروه محصول با موفقیت بروزرسانی شد.');
    }

    /**
     * حذف
     */
    public function destroy(
        ProductGroup $productGroup,
        ProductGroupTranslation $translation
    ): RedirectResponse {
        $this->ensureTranslationBelongsToGroup(
            $productGroup,
            $translation
        );

        $translation->delete();

        return redirect()
            ->route(
                'admin.productGroup.translations.index',
                $productGroup
            )
            ->with('success', 'ترجمه با موفقیت حذف شد.');
    }

    /**
     * تولید slug یکتا
     */
    private function generateUniqueSlug(
        string $value,
        string $locale,
        ?int $ignoreId = null
    ): string {
        $slug = Str::slug($value);

        if ($slug === '') {
            $slug = 'group-' . time();
        }

        $originalSlug = $slug;
        $counter = 1;

        while (
        ProductGroupTranslation::query()
            ->where('locale', $locale)
            ->where('slug', $slug)
            ->when(
                $ignoreId,
                fn ($query) => $query->where('id', '!=', $ignoreId)
            )
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * اطمینان از تعلق ترجمه به گروه
     */
    private function ensureTranslationBelongsToGroup(
        ProductGroup $productGroup,
        ProductGroupTranslation $translation
    ): void {
        abort_unless(
            $translation->product_group_id === $productGroup->id,
            404
        );
    }
}
