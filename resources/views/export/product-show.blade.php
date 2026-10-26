@extends('layouts.home')

@section('title', $product->name)

@section('content')
    <div class="container py-5">

        <div class="row g-4">

            {{-- تصویر اصلی --}}
            <div class="col-md-6">
                @if($product->image)
                    <img src="{{ $product->image_url }}"
                         class="img-fluid rounded"
                         alt="{{ $product->name }}">
                @endif

                {{-- گالری --}}
                @if(! empty($product->gallery_urls))
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        @foreach($product->gallery_urls as $url)
                            <img src="{{ $url }}"
                                 alt="{{ $product->name }} - {{ __('product_export.gallery') }}"
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- اطلاعات --}}
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>

                @if($product->short_description)
                    <p class="lead">{{ $product->short_description }}</p>
                @endif

                <table class="table table-sm">
                    @if($product->sku)
                        <tr>
                            <th>{{ __('product_export.sku') }}:</th>
                            <td><code>{{ $product->sku }}</code></td>
                        </tr>
                    @endif
                    @if($product->product_type_label)
                        <tr>
                            <th>{{ __('product_export.product_type') }}:</th>
                            <td>{{ $product->product_type_label }}</td>
                        </tr>
                    @endif
                    @if($product->unit_label)
                        <tr>
                            <th>{{ __('product_export.unit') }}:</th>
                            <td>{{ $product->unit_label }}</td>
                        </tr>
                    @endif
                    @if($product->minimum_order_quantity)
                        <tr>
                            <th>{{ __('product_export.minimum_order') }}:</th>
                            <td>{{ $product->minimum_order_quantity }}</td>
                        </tr>
                    @endif
                    @if($product->origin_country)
                        <tr>
                            <th>{{ __('product_export.origin_country') }}:</th>
                            <td>{{ $product->origin_country }}</td>
                        </tr>
                    @endif
                    @if($product->packaging_type)
                        <tr>
                            <th>{{ __('product_export.packaging') }}:</th>
                            <td>{{ $product->packaging_type }}</td>
                        </tr>
                    @endif
                </table>

                @if($product->description)
                    <div class="mt-4">
                        <h5>{{ __('product_export.description') }}:</h5>
                        <p style="white-space: pre-wrap;">{{ $product->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
