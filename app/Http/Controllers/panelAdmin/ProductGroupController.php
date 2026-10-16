<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductGroupRequest;
use App\Http\Requests\UpdateProductGroupRequest;
use App\Models\ProductGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductGroupController extends Controller
{
    /* ============================================================
     |  Index
     ============================================================ */
    public function index(Request $request): View
    {
        $groups = ProductGroup::query()
            ->with(['translations'])
            ->withCount('categories')
            ->when($request->filled('search'),
                fn ($q) => $q->search($request->string('search')))
            ->when($request->filled('type'),
                fn ($q) => $q->ofType($request->string('type')))
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->string('status') === 'active');
            })
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('panelAdmin.productGroup.index', compact('groups'));
    }

    /* ============================================================
     |  Create
     ============================================================ */
    public function create(): View
    {
        return view('panelAdmin.productGroup.create');
    }

    /* ============================================================
     |  Store
     ============================================================ */
    public function store(StoreProductGroupRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $group = null;

        DB::transaction(function () use ($request, &$data, &$group) {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('product-groups', 'public');
            }

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            // code خودکار در Model ساخته می‌شود
            $group = ProductGroup::create($data);

            $this->saveTranslations($group, $translations);
        });

        return redirect()
            ->route('admin.productGroup.index')
            ->with('success', 'گروه محصول با موفقیت ایجاد شد. کد: ' . $group->code);
    }

    /* ============================================================
     |  Show
     ============================================================ */
    public function show(ProductGroup $productGroup): View
    {
        $productGroup->load(['translations', 'categories.translations']);

        return view('panelAdmin.productGroup.show', compact('productGroup'));
    }

    /* ============================================================
     |  Edit
     ============================================================ */
    public function edit(ProductGroup $productGroup): View
    {
        $productGroup->load(['translations']);

        return view('panelAdmin.productGroup.edit', compact('productGroup'));
    }

    /* ============================================================
     |  Update
     ============================================================ */
    public function update(UpdateProductGroupRequest $request, ProductGroup $productGroup): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($request, $productGroup, &$data) {
            if ($request->hasFile('image')) {
                if ($productGroup->image && Storage::disk('public')->exists($productGroup->image)) {
                    Storage::disk('public')->delete($productGroup->image);
                }
                $data['image'] = $request->file('image')->store('product-groups', 'public');
            } else {
                unset($data['image']);
            }

            // code نباید تغییر کند
            unset($data['code']);

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            $productGroup->update($data);

            $this->saveTranslations($productGroup, $translations);
        });

        return redirect()
            ->route('admin.productGroup.index')
            ->with('success', 'گروه محصول با موفقیت به‌روزرسانی شد.');
    }

    /* ============================================================
     |  Destroy
     ============================================================ */
    public function destroy(ProductGroup $productGroup): RedirectResponse
    {
        // جلوگیری از حذف اگر دسته‌بندی دارد
        if ($productGroup->categories()->exists()) {
            return back()->with('error', 'ابتدا باید دسته‌بندی‌های این گروه را حذف یا منتقل کنید.');
        }

        DB::transaction(function () use ($productGroup) {
            if ($productGroup->image && Storage::disk('public')->exists($productGroup->image)) {
                Storage::disk('public')->delete($productGroup->image);
            }

            $productGroup->delete();
        });

        return redirect()
            ->route('admin.productGroup.index')
            ->with('success', 'گروه محصول با موفقیت حذف شد.');
    }

    /* ============================================================
     |  Helper: Save Translations
     ============================================================ */
    protected function saveTranslations(ProductGroup $group, array $translations): void
    {
        foreach ($translations as $locale => $values) {
            if (empty($values['name'])) {
                continue;
            }

            if (empty($values['slug'])) {
                $values['slug'] = ProductGroup::generateUniqueSlug(
                    $values['name'],
                    $locale,
                    $group->id
                );
            }

            $group->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'name'              => $values['name'],
                    'slug'              => $values['slug'],
                    'short_description' => $values['short_description'] ?? null,
                    'description'       => $values['description'] ?? null,
                    'meta_title'        => $values['meta_title'] ?? null,
                    'meta_description'  => $values['meta_description'] ?? null,
                    'meta_keywords'     => $values['meta_keywords'] ?? null,
                ]
            );
        }
    }
}
