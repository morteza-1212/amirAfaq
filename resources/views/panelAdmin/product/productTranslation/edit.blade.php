@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش ترجمه محصول')

@section('style')
    <style>
        .translation-edit {
            direction: rtl;
            padding: 20px;
        }

        .card {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 14px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .full {
            grid-column: 1 / -1;
        }

        input,
        select,
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .actions {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 11px 20px;
            border: 0;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        .primary {
            background: #2563eb;
            color: white;
        }

        .secondary {
            background: #64748b;
            color: white;
        }

        @media(max-width:700px) {

            .translation-edit {
                padding: 10px;
            }

            .card {
                padding: 15px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }
        }
    </style>
@endsection

@section('content')

    <div class="translation-edit">

        <div class="card">

            <h1>ویرایش ترجمه</h1>

            <p>
                محصول:
                <strong>{{ $product->code }}</strong>
            </p>

            <form
                action="{{ route(
                'admin.product.translation.update',
                [$product, $translation]
            ) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="grid">

                    <div class="field">

                        <label>زبان</label>

                        <select name="locale">

                            @foreach($locales as $code => $name)

                                <option
                                    value="{{ $code }}"
                                    @selected(
                                        old(
                                            'locale',
                                            $translation->locale
                                        ) === $code
                                    )>

                                    {{ $name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="field">

                        <label>نام محصول</label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old(
                            'name',
                            $translation->name
                        ) }}"
                            required>

                    </div>

                    <div class="field">

                        <label>Slug</label>

                        <input
                            type="text"
                            name="slug"
                            value="{{ old(
                            'slug',
                            $translation->slug
                        ) }}">

                    </div>

                    <div class="field full">

                        <label>توضیح کوتاه</label>

                        <textarea
                            name="short_description">{{ old(
                            'short_description',
                            $translation->short_description
                        ) }}</textarea>

                    </div>

                    <div class="field full">

                        <label>توضیحات</label>

                        <textarea
                            name="description">{{ old(
                            'description',
                            $translation->description
                        ) }}</textarea>

                    </div>

                    <div class="field full">

                        <label>مشخصات محصول</label>

                        <textarea
                            name="specifications">{{ old(
                            'specifications',
                            $translation->specifications
                        ) }}</textarea>

                    </div>

                    <div class="field full">

                        <label>ویژگی‌ها</label>

                        <textarea
                            name="features">{{ old(
                            'features',
                            $translation->features
                        ) }}</textarea>

                    </div>

                    <div class="field">

                        <label>بسته‌بندی</label>

                        <textarea
                            name="packaging">{{ old(
                            'packaging',
                            $translation->packaging
                        ) }}</textarea>

                    </div>

                    <div class="field">

                        <label>اطلاعات حمل و نقل</label>

                        <textarea
                            name="shipping_info">{{ old(
                            'shipping_info',
                            $translation->shipping_info
                        ) }}</textarea>

                    </div>

                    <div class="field">

                        <label>عنوان SEO</label>

                        <input
                            type="text"
                            name="meta_title"
                            value="{{ old(
                            'meta_title',
                            $translation->meta_title
                        ) }}">

                    </div>

                    <div class="field">

                        <label>کلمات کلیدی</label>

                        <input
                            type="text"
                            name="meta_keywords"
                            value="{{ old(
                            'meta_keywords',
                            $translation->meta_keywords
                        ) }}">

                    </div>

                    <div class="field full">

                        <label>توضیحات SEO</label>

                        <textarea
                            name="meta_description">{{ old(
                            'meta_description',
                            $translation->meta_description
                        ) }}</textarea>

                    </div>

                </div>

                <div class="actions">

                    <button class="btn primary">
                        ذخیره تغییرات
                    </button>

                    <a
                        href="{{ route(
                        'admin.product.translation.index',
                        $product
                    ) }}"
                        class="btn secondary">
                        بازگشت
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection
