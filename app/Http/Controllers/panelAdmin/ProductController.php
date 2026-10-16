<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /* ============================================================
     |  Index
     ============================================================ */
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with(['translations', 'category.translations'])
            ->when($request->filled('search'),
                fn ($q) => $q->search($request->string('search')))
            ->when($request->filled('type'),
                fn ($q) => $q->ofType($request->string('type')))
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('is_active', $request->string('status') === 'active');
            })
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('panelAdmin.product.index', compact('products'));
    }

    /* ============================================================
     |  Create
     ============================================================ */
    public function create(): View
    {
        $categories = Category::with('translations')->get();

        return view('panelAdmin.product.create', compact('categories'));
    }

    /* ============================================================
     |  Store
     ============================================================ */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $product = null;

        DB::transaction(function () use ($request, &$data, &$product) {
            // تصویر اصلی
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            // گالری
            if ($request->hasFile('gallery')) {
                $galleryPaths = [];
                foreach ($request->file('gallery') as $file) {
                    $galleryPaths[] = $file->store('products/gallery', 'public');
                }
                $data['gallery'] = $galleryPaths;
            }

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            // کد محصول خودکار ساخته می‌شود (در Model)
            $product = Product::create($data);

            $this->saveTranslations($product, $translations);
        });

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'محصول با موفقیت ایجاد شد. کد: ' . $product->code);
    }

    /* ============================================================
     |  Show
     ============================================================ */
    public function show(Product $product): View
    {
        $product->load(['translations', 'category.translations']);

        return view('panelAdmin.product.show', compact('product'));
    }

    /* ============================================================
     |  Edit
     ============================================================ */
    public function edit(Product $product): View
    {
        $product->load(['translations', 'category.translations']);
        $categories = Category::with('translations')->get();

        return view('panelAdmin.product.edit', compact('product', 'categories'));
    }

    /* ============================================================
     |  Update
     ============================================================ */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($request, $product, &$data) {
            // تصویر اصلی
            if ($request->hasFile('image')) {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $request->file('image')->store('products', 'public');
            } else {
                unset($data['image']);
            }

            // گالری
            if ($request->hasFile('gallery')) {
                if (! empty($product->gallery)) {
                    foreach ($product->gallery as $oldImage) {
                        if (Storage::disk('public')->exists($oldImage)) {
                            Storage::disk('public')->delete($oldImage);
                        }
                    }
                }

                $galleryPaths = [];
                foreach ($request->file('gallery') as $file) {
                    $galleryPaths[] = $file->store('products/gallery', 'public');
                }
                $data['gallery'] = $galleryPaths;
            } else {
                unset($data['gallery']);
            }

            // code نباید قابل تغییر باشد
            unset($data['code']);

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            $product->update($data);

            $this->saveTranslations($product, $translations);
        });

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'محصول با موفقیت به‌روزرسانی شد.');
    }

    /* ============================================================
     |  Destroy
     ============================================================ */
    public function destroy(Product $product): RedirectResponse
    {
        DB::transaction(function () use ($product) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            if (! empty($product->gallery)) {
                foreach ($product->gallery as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            $product->delete();
        });

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'محصول با موفقیت حذف شد.');
    }

    /* ============================================================
     |  Helper: Save Translations
     ============================================================ */
    protected function saveTranslations(Product $product, array $translations): void
    {
        foreach ($translations as $locale => $values) {
            if (empty($values['name'])) {
                continue;
            }

            if (empty($values['slug'])) {
                $values['slug'] = Product::generateUniqueSlug(
                    $values['name'],
                    $locale,
                    $product->id
                );
            }

            $product->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'name'              => $values['name'],
                    'slug'              => $values['slug'],
                    'short_description' => $values['short_description'] ?? null,
                    'description'       => $values['description'] ?? null,
                    'specifications'    => $values['specifications'] ?? null,
                    'features'          => $values['features'] ?? null,
                    'packaging'         => $values['packaging'] ?? null,
                    'shipping_info'     => $values['shipping_info'] ?? null,
                    'meta_title'        => $values['meta_title'] ?? null,
                    'meta_description'  => $values['meta_description'] ?? null,
                    'meta_keywords'     => $values['meta_keywords'] ?? null,
                    'alt_text'          => $values['alt_text'] ?? null,
                ]
            );
        }
    }
}
