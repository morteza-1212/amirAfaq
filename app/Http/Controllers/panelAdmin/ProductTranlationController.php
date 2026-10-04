<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTranlation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductTranlationController extends Controller
{
    public function index(Product $product)
    {
        $product->load('translations');

        return view(
            'panelAdmin.product.productTranslation.index',
            compact('product')
        );
    }

    public function create(Product $product)
    {
        $existingLocales = $product
            ->translations()
            ->pluck('locale')
            ->toArray();

        $locales = [
            'fa' => 'فارسی',
            'en' => 'English',
            'ar' => 'العربية',
        ];

        return view(
            'panelAdmin.product.productTranslation.create',
            compact(
                'product',
                'existingLocales',
                'locales'
            )
        );
    }

    public function store(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([

            'locale' => [
                'required',
                Rule::in(['fa', 'en', 'ar']),
                Rule::unique('product_tranlations')
                    ->where(function ($query) use ($product) {
                        return $query->where(
                            'product_id',
                            $product->id
                        );
                    }),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('product_tranlations')
                    ->where(function ($query) use ($request) {
                        return $query->where(
                            'locale',
                            $request->input('locale')                        );
                    }),
            ],

            'short_description' => [
                'nullable',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'specifications' => [
                'nullable',
                'string',
            ],

            'features' => [
                'nullable',
                'string',
            ],

            'packaging' => [
                'nullable',
                'string',
            ],

            'shipping_info' => [
                'nullable',
                'string',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug(
                $validated['name']
            );
        }

        $product->translations()->create(
            $validated
        );

        return redirect()
            ->route(
                'admin.product.translation.index',
                $product
            )
            ->with(
                'success',
                'ترجمه محصول با موفقیت ایجاد شد.'
            );
    }

    public function edit(
        Product $product,
        ProductTranlation $translation
    ) {
        abort_unless(
            $translation->product_id === $product->id,
            404
        );

        $locales = [
            'fa' => 'فارسی',
            'en' => 'English',
            'ar' => 'العربية',
        ];

        return view(
            'panelAdmin.product.productTranslation.edit',
            compact(
                'product',
                'translation',
                'locales'
            )
        );
    }

    public function update(
        Request $request,
        Product $product,
        ProductTranlation $translation
    ) {
        abort_unless(
            $translation->product_id === $product->id,
            404
        );

        $validated = $request->validate([

            'locale' => [
                'required',
                Rule::in(['fa', 'en', 'ar']),
                Rule::unique('product_tranlations')
                    ->where(function ($query) use ($product) {
                        return $query->where(
                            'product_id',
                            $product->id
                        );
                    })
                    ->ignore($translation->id),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('product_tranlations')
                    ->where(function ($query) use ($request) {
                        return $query->where(
                            'locale',
                            $request->input('locale')                        );
                    })
                    ->ignore($translation->id),
            ],

            'short_description' => [
                'nullable',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'specifications' => [
                'nullable',
                'string',
            ],

            'features' => [
                'nullable',
                'string',
            ],

            'packaging' => [
                'nullable',
                'string',
            ],

            'shipping_info' => [
                'nullable',
                'string',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug(
                $validated['name']
            );
        }

        $translation->update($validated);

        return redirect()
            ->route(
                'admin.product.translation.index',
                $product
            )
            ->with(
                'success',
                'ترجمه با موفقیت بروزرسانی شد.'
            );
    }

    public function destroy(
        Product $product,
        ProductTranlation $translation
    ) {
        abort_unless(
            $translation->product_id === $product->id,
            404
        );

        $translation->delete();

        return redirect()
            ->route(
                'admin.product.translation.index',
                $product
            )
            ->with(
                'success',
                'ترجمه با موفقیت حذف شد.'
            );
    }
}
