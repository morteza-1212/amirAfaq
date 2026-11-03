<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_shop_id'    => ['required', 'exists:category_shops,id'],
            'name'                => ['required', 'string', 'max:200'],
            'slug'                => ['nullable', 'string', 'max:220', 'unique:product_shops,slug'],
            'sku' => ['nullable', 'string', 'max:100', 'unique:product_shops,sku'],            'short_description'   => ['nullable', 'string', 'max:500'],
            'description'         => ['nullable', 'string'],
            'brand'               => ['nullable', 'string', 'max:150'],
            'country_of_origin'   => ['nullable', 'string', 'max:100'],
            'product_type'        => ['required', 'in:physical,digital'],
            'price'               => ['required', 'integer', 'min:0'],
            'compare_price'       => ['nullable', 'integer', 'min:0'],
            'cost_price'          => ['nullable', 'integer', 'min:0'],
            'tax_rate'            => ['nullable', 'numeric', 'min:0', 'max:100'],
            'manage_stock'        => ['nullable', 'boolean'],
            'stock_quantity'      => ['nullable', 'integer', 'min:0'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'allow_backorder'     => ['nullable', 'boolean'],
            'weight'              => ['nullable', 'integer', 'min:0'],
            'length'              => ['nullable', 'integer', 'min:0'],
            'width'               => ['nullable', 'integer', 'min:0'],
            'height'              => ['nullable', 'integer', 'min:0'],
            'image'               => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'status'              => ['required', 'in:draft,published,archived'],
            'is_featured'         => ['nullable', 'boolean'],
            'sort_order'          => ['nullable', 'integer', 'min:0'],
            'published_at'        => ['nullable', 'date'],
            'meta_title'          => ['nullable', 'string', 'max:255'],
            'meta_description'    => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_shop_id.required' => 'انتخاب دسته‌بندی الزامی است.',
            'category_shop_id.exists'   => 'دسته‌بندی انتخاب‌شده معتبر نیست.',
            'name.required'             => 'نام محصول الزامی است.',
            'slug.unique'               => 'این Slug قبلاً استفاده شده است.',
            'sku.required'              => 'کد محصول (SKU) الزامی است.',
            'sku.unique'                => 'این کد محصول قبلاً استفاده شده است.',
            'product_type.required'     => 'نوع محصول الزامی است.',
            'product_type.in'           => 'نوع محصول باید physical یا digital باشد.',
            'price.required'            => 'قیمت فروش الزامی است.',
            'price.integer'             => 'قیمت باید عدد باشد.',
            'status.required'           => 'وضعیت محصول الزامی است.',
            'status.in'                 => 'وضعیت محصول معتبر نیست.',
            'image.image'               => 'فایل انتخاب‌شده باید تصویر باشد.',
            'image.mimes'               => 'فرمت تصویر باید jpeg، png، jpg، gif یا webp باشد.',
            'image.max'                 => 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.',
        ];
    }

    public function attributes(): array
    {
        return [
            'category_shop_id'    => 'دسته‌بندی',
            'name'                => 'نام',
            'slug'                => 'Slug',
            'sku'                 => 'کد محصول',
            'short_description'   => 'توضیح کوتاه',
            'description'         => 'توضیحات',
            'brand'               => 'برند',
            'country_of_origin'   => 'کشور سازنده',
            'product_type'        => 'نوع محصول',
            'price'               => 'قیمت',
            'compare_price'       => 'قیمت قبل از تخفیف',
            'cost_price'          => 'قیمت تمام‌شده',
            'tax_rate'            => 'مالیات',
            'stock_quantity'      => 'موجودی',
            'low_stock_threshold' => 'حداقل موجودی',
            'weight'              => 'وزن',
            'length'              => 'طول',
            'width'               => 'عرض',
            'height'              => 'ارتفاع',
            'image'               => 'تصویر',
            'status'              => 'وضعیت',
            'sort_order'          => 'ترتیب',
            'published_at'        => 'زمان انتشار',
            'meta_title'          => 'عنوان سئو',
            'meta_description'    => 'توضیحات سئو',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'manage_stock'        => $this->boolean('manage_stock'),
            'allow_backorder'     => $this->boolean('allow_backorder'),
            'is_featured'         => $this->boolean('is_featured'),
            'tax_rate'            => $this->filled('tax_rate') ? $this->tax_rate : 0,
            'stock_quantity'      => $this->filled('stock_quantity') ? (int) $this->stock_quantity : 0,
            'low_stock_threshold' => $this->filled('low_stock_threshold') ? (int) $this->low_stock_threshold : 5,
            'sort_order'          => $this->filled('sort_order') ? (int) $this->sort_order : 0,
        ]);
    }
}
