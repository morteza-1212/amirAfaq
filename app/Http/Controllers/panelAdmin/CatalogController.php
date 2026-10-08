<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCatalogRequest;
use App\Http\Requests\UpdateCatalogRequest;
use App\Models\Catalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /* ========== لیست ========== */
    public function index(): View
    {
        $catalogs = Catalog::ordered()->paginate(15);

        return view('panelAdmin.catalog.index', compact('catalogs'));
    }

    /* ========== فرم ایجاد ========== */
    public function create(): View
    {
        return view('panelAdmin.catalog.create');
    }

    /* ========== ذخیره ========== */
    public function store(StoreCatalogRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // اگر اسلاگ خالی بود، خودکار تولید کن
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug();
        }

        Catalog::create($data);

        return redirect()
            ->route('admin.catalog.index')
            ->with('success', 'کاتالوگ با موفقیت ایجاد شد.');
    }

    /**
     * تولید اسلاگ یکتا مثل: catalog-1712345678
     */
    protected function generateUniqueSlug(): string
    {
        do {
            $slug = 'catalog-' . now()->timestamp . '-' . rand(100, 999);
        } while (Catalog::where('slug', $slug)->exists());

        return $slug;
    }

    /* ========== نمایش ========== */
    public function show(Catalog $catalog): View
    {
        return view('admin.catalogs.show', compact('catalog'));
    }

    /* ========== فرم ویرایش ========== */
    public function edit(Catalog $catalog): View
    {
        return view('panelAdmin.catalog.edit', compact('catalog'));
    }

    /* ========== به‌روزرسانی ========== */
    public function update(UpdateCatalogRequest $request, Catalog $catalog): RedirectResponse
    {
        $data = $request->validated();

        // اگر اسلاگ خالی بود، اسلاگ قبلی حفظ شود
        if (empty($data['slug'])) {
            $data['slug'] = $catalog->slug;
        }

        // اگر اسلاگ تغییر کرده و در دیتابیس موجود است، خطا بده
        if ($data['slug'] !== $catalog->slug
            && Catalog::where('slug', $data['slug'])->where('id', '!=', $catalog->id)->exists()) {
            return back()
                ->withErrors(['slug' => 'این اسلاگ قبلاً استفاده شده است.'])
                ->withInput();
        }

        $catalog->update($data);

        return redirect()
            ->route('admin.catalog.index')
            ->with('success', "کاتالوگ «{$catalog->slug}» با موفقیت به‌روزرسانی شد.");
    }

    /* ========== حذف ========== */
    public function destroy(Catalog $catalog): RedirectResponse
    {
        $catalog->delete();

        return redirect()
            ->route('admin.catalog.index')
            ->with('success', 'کاتالوگ با موفقیت حذف شد.');
    }

    /* ========== تغییر وضعیت (AJAX) ========== */
    public function toggleStatus(Catalog $catalog): RedirectResponse
    {
        $catalog->update(['is_active' => ! $catalog->is_active]);

        return back()->with('success', 'وضعیت کاتالوگ تغییر کرد.');
    }
}
