<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBuyerRequest;
use App\Models\Buyer;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\TradeTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /* ============================================================
     |  صفحات اصلی
     ============================================================ */

    public function index(): View
    {
        return view('index');
    }

    public function AbouteUs(): View
    {
        return view('Aboute.index');
    }

    public function export(): View
    {
        return view('export.index');
    }

    public function import(): View
    {
        return view('import.index');
    }

    public function logistics(): View
    {
        return view('Logistics.index');
    }

    public function markets(): View
    {
        return view('markets.index');
    }

    public function suppliers(): View
    {
        return view('suppliers.index');
    }

    public function buyer(): View
    {
        return view('buyers.index');
    }

    public function contact(): View
    {
        return view('contactUs.index');
    }

//    public function productExport(): View
//    {
//        return view('export.products');
//    }
    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'required|string|max:50',
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:5000',
        ]);

        Contact::create($validated);

        return back()->with('success', __('contact.success_message'));
    }

//    public function gallery(): View
//    {
//        return view('gallery.index');
//    }

    public function services(): View
    {
        return view('services.index');
    }

    /* ============================================================
     |  Catalogs
     ============================================================ */

    public function catalogs(): View
    {
        $locale = app()->getLocale();

        $catalogs = \App\Models\Catalog::query()
            ->where('is_active', true)
            ->with([
                'translations' => function ($q) use ($locale) {
                    $q->where('locale', $locale);
                },
            ])
            ->orderBy('sort_order')
            ->get()
            ->filter(fn ($catalog) => $catalog->translations->isNotEmpty());

        return view('catalogs.index', compact('catalogs', 'locale'));
    }

    /* ============================================================
     |  Buyers
     ============================================================ */

    public function store(StoreBuyerRequest $request): RedirectResponse
    {
        Buyer::create($request->validated());

        return redirect()
            ->route('buyer', ['locale' => app()->getLocale()])
            ->with('success', __('buyers.success_message'));
    }

    /* ============================================================
     |  Projects (Trade Transactions)
     ============================================================ */

    /**
     * نمایش پروژه‌های انجام شده با پشتیبانی از سه زبان
     */
    public function trads(Request $request, ?string $locale = null): View
    {
        // زبان از middleware یا app
        $currentLocale = app()->getLocale();

        // دریافت پروژه‌های منتشرشده با ترجمه‌ها
        $trads = TradeTransaction::query()
            ->with(['translations'])
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderByDesc('contract_date')
            ->orderByDesc('created_at')
            ->get();

        return view('projects.index', [
            'trads'         => $trads,
            'currentLocale' => $currentLocale,
        ]);
    }
    public function gallery(Request $request, ?string $locale = null): View
    {
        $currentLocale = app()->getLocale();

        $galleries = \App\Models\Gallery::query()
            ->with(['translations' => function ($q) use ($currentLocale) {
                $q->whereIn('locale', [$currentLocale, \App\Models\Gallery::DEFAULT_LOCALE]);
            }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return view('gallery.index', [
            'galleries'     => $galleries,
            'currentLocale' => $currentLocale,
        ]);
    }
    public function productExport(Request $request, ?string $locale = null): View
    {
        $currentLocale = app()->getLocale();

        // محصولات صادراتی فعال و قابل صادرات
        $products = \App\Models\ProductExport::query()
            ->with(['translations', 'category.translations'])
            ->where('is_active', true)
            ->where('is_exportable', true)
            ->ordered()
            ->paginate(12);

        return view('export.products', [
            'products'      => $products,
            'currentLocale' => $currentLocale,
        ]);
    }
    public function productExportShow(string $locale, \App\Models\ProductExport $productExport): View
    {
        $productExport->load(['translations', 'category.translations']);

        return view('export.product-show', [
            'product'       => $productExport,
            'currentLocale' => app()->getLocale(),
        ]);
    }
}
