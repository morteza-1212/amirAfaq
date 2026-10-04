@extends('panelAdmin.layouts.panel')

@section('title', 'افزودن ترجمه گروه محصول')

@section('style')
    <style>
        .translation-form-page {
            direction: rtl;
            max-width: 1000px;
            margin: auto;
        }

        .form-card {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
        }

        .form-title {
            margin-bottom: 25px;
        }

        .form-title h1 {
            margin: 0 0 8px;
            font-size: 23px;
            font-weight: 800;
        }

        .form-title p {
            margin: 0;
            color: #6b7280;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .form-control {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 11px 13px;
            font-size: 14px;
            outline: none;
            transition: .2s;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        textarea.form-control {
            min-height: 130px;
            resize: vertical;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
        }

        .form-actions {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            border: 0;
            border-radius: 10px;
            padding: 11px 18px;
            text-decoration: none;
            cursor: pointer;
            font-weight: 700;
        }

        .btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }

        @media(max-width: 768px) {
            .form-card {
                padding: 18px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')

    <div class="translation-form-page">

        <div class="form-card">

            <div class="form-title">

                <h1>
                    افزودن ترجمه
                </h1>

                <p>
                    گروه:
                    <strong>
                        {{ $productGroup->name ?? 'گروه محصول' }}
                    </strong>
                </p>

            </div>

            <form
                action="{{ route(
                'admin.productGroup.translations.store',
                $productGroup
            ) }}"
                method="POST"
            >

                @csrf

                <div class="form-grid">

                    <div class="form-group">

                        <label class="form-label">
                            زبان *
                        </label>

                        <select
                            name="locale"
                            class="form-control"
                            required
                        >

                            <option value="">
                                انتخاب زبان
                            </option>

                            @foreach($availableLocales as $locale => $label)

                                <option
                                    value="{{ $locale }}"
                                    @selected(old('locale') === $locale)
                                >
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                        @error('locale')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            نام *
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-control"
                            required
                        >

                        @error('name')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Slug
                        </label>

                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug') }}"
                            class="form-control"
                            placeholder="example-product"
                        >

                        @error('slug')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </div>


                    <div class="form-group full">

                        <label class="form-label">
                            توضیح کوتاه
                        </label>

                        <textarea
                            name="short_description"
                            class="form-control"
                            maxlength="500"
                        >{{ old('short_description') }}</textarea>

                        @error('short_description')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </div>


                    <div class="form-group full">

                        <label class="form-label">
                            توضیحات
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                        >{{ old('description') }}</textarea>

                        @error('description')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            عنوان SEO
                        </label>

                        <input
                            type="text"
                            name="meta_title"
                            value="{{ old('meta_title') }}"
                            class="form-control"
                        >

                        @error('meta_title')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            کلمات کلیدی SEO
                        </label>

                        <input
                            type="text"
                            name="meta_keywords"
                            value="{{ old('meta_keywords') }}"
                            class="form-control"
                            placeholder="product, export, import"
                        >

                        @error('meta_keywords')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </div>


                    <div class="form-group full">

                        <label class="form-label">
                            توضیحات SEO
                        </label>

                        <textarea
                            name="meta_description"
                            class="form-control"
                        >{{ old('meta_description') }}</textarea>

                        @error('meta_description')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </div>

                </div>


                <div class="form-actions">

                    <a
                        href="{{ route(
                        'admin.productGroup.translations.index',
                        $productGroup
                    ) }}"
                        class="btn btn-secondary"
                    >
                        انصراف
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        ذخیره ترجمه
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
