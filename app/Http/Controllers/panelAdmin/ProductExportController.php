<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductExportRequest;
use App\Http\Requests\UpdateProductExportRequest;
use App\Models\Category;
use App\Models\ProductExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductExportController extends Controller
{
    /* ============================================================
     |  Index
     ============================================================ */
    public function index(Request $request): View
    {
        $products = ProductExport::query()
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

        return view('panelAdmin.productExport.index', compact('products'));
    }

    /* ============================================================
     |  Create
     ============================================================ */
    public function create(): View
    {
        $categories = Category::with('translations')->ordered()->get();

        return view('panelAdmin.productExport.create', compact('categories'));
    }

    /* ============================================================
     |  Store
     ============================================================ */
    public function store(StoreProductExportRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $product = null;

        DB::transaction(function () use ($request, &$data, &$product) {
            // تصویر اصلی
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('product-exports', 'public');
            }

            // گالری
            if ($request->hasFile('gallery')) {
                $galleryPaths = [];
                foreach ($request->file('gallery') as $file) {
                    $galleryPaths[] = $file->store('product-exports/gallery', 'public');
                }
                $data['gallery'] = $galleryPaths;
            }

            // specifications: JSON
            if (! empty($data['specifications'])) {
                $specs = json_decode($data['specifications'], true);
                $data['specifications'] = is_array($specs) ? $specs : null;
            } else {
                unset($data['specifications']);
            }

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            $product = ProductExport::create($data);

            $this->saveTranslations($product, $translations);
        });

        return redirect()
            ->route('admin.productExport.index')
            ->with('success', 'محصول صادراتی با موفقیت ایجاد شد.');
    }

    /* ============================================================
     |  Show
     ============================================================ */
    public function show(ProductExport $productExport): View
    {
        $productExport->load(['translations', 'category.translations']);

        return view('panelAdmin.productExport.show', compact('productExport'));
    }

    /* ============================================================
     |  Edit
     ============================================================ */
    public function edit(ProductExport $productExport): View
    {
        $productExport->load(['translations', 'category.translations']);
        $categories = Category::with('translations')->ordered()->get();

        return view('panelAdmin.productExport.edit', compact('productExport', 'categories'));
    }

    /* ============================================================
     |  Update
     ============================================================ */
    public function update(UpdateProductExportRequest $request, ProductExport $productExport): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($request, $productExport, &$data) {
            // تصویر اصلی
            if ($request->hasFile('image')) {
                if ($productExport->image && Storage::disk('public')->exists($productExport->image)) {
                    Storage::disk('public')->delete($productExport->image);
                }
                $data['image'] = $request->file('image')->store('product-exports', 'public');
            } else {
                unset($data['image']);
            }

            // گالری
            if ($request->hasFile('gallery')) {
                if (! empty($productExport->gallery)) {
                    foreach ($productExport->gallery as $oldImage) {
                        if (Storage::disk('public')->exists($oldImage)) {
                            Storage::disk('public')->delete($oldImage);
                        }
                    }
                }

                $galleryPaths = [];
                foreach ($request->file('gallery') as $file) {
                    $galleryPaths[] = $file->store('product-exports/gallery', 'public');
                }
                $data['gallery'] = $galleryPaths;
            } else {
                unset($data['gallery']);
            }

            // specifications
            if (! empty($data['specifications'])) {
                $specs = json_decode($data['specifications'], true);
                $data['specifications'] = is_array($specs) ? $specs : null;
            } else {
                unset($data['specifications']);
            }

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            $productExport->update($data);

            $this->saveTranslations($productExport, $translations);
        });

        return redirect()
            ->route('admin.productExport.index')
            ->with('success', 'محصول صادراتی با موفقیت به‌روزرسانی شد.');
    }

    /* ============================================================
     |  Destroy
     ============================================================ */
    public function destroy(ProductExport $productExport): RedirectResponse
    {
        DB::transaction(function () use ($productExport) {
            if ($productExport->image && Storage::disk('public')->exists($productExport->image)) {
                Storage::disk('public')->delete($productExport->image);
            }

            if (! empty($productExport->gallery)) {
                foreach ($productExport->gallery as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            $productExport->delete();
        });

        return redirect()
            ->route('admin.productExport.index')
            ->with('success', 'محصول صادراتی با موفقیت حذف شد.');
    }

    /* ============================================================
     |  Helper: Save Translations
     ============================================================ */
    protected function saveTranslations(ProductExport $product, array $translations): void
    {
        foreach ($translations as $locale => $values) {
            if (empty($values['name'])) {
                continue;
            }

            $product->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'name'                  => $values['name'],
                    'meta_title'            => $values['meta_title'] ?? null,
                    'short_description'     => $values['short_description'] ?? null,
                    'description'           => $values['description'] ?? null,
                    'features'              => $values['features'] ?? null,
                    'packaging_description' => $values['packaging_description'] ?? null,
                    'meta_keywords'         => $values['meta_keywords'] ?? null,
                    'meta_description'      => $values['meta_description'] ?? null,
                ]
            );
        }
    }
}
