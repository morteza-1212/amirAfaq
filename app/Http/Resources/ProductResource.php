<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'slug'              => $this->slug,
            'sku'               => $this->sku,
            'short_description' => $this->short_description,
            'brand'             => $this->brand,
            'country_of_origin' => $this->country_of_origin,
            'product_type'      => $this->product_type,
            'price'             => $this->price,
            'compare_price'     => $this->compare_price,
            'discount_percent'  => $this->discountPercent(), // متد کمکی در مدل
            'image'             => $this->image,
            'is_featured'       => $this->is_featured,
            'status'            => $this->status,
            'published_at'      => $this->published_at?->toIso8601String(),

            // موجودی (فقط خلاصه)
            'in_stock'          => $this->manage_stock
                ? $this->stock_quantity > 0
                : true,
            'stock_quantity'    => $this->manage_stock ? $this->stock_quantity : null,

            // دسته‌بندی
            'category'          => $this->whenLoaded('category', fn () => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug ?? null,
            ]),

            // در جزئیات بیشتر
            'description'       => $this->when(
                $request->routeIs('products.show'),
                fn () => $this->description
            ),
            'weight'            => $this->when($request->routeIs('products.show'), $this->weight),
            'length'            => $this->when($request->routeIs('products.show'), $this->length),
            'width'             => $this->when($request->routeIs('products.show'), $this->width),
            'height'            => $this->when($request->routeIs('products.show'), $this->height),
            'meta_title'        => $this->when($request->routeIs('products.show'), $this->meta_title),
            'meta_description'  => $this->when($request->routeIs('products.show'), $this->meta_description),
            'created_at'        => $this->created_at?->toIso8601String(),
        ];
    }
}
