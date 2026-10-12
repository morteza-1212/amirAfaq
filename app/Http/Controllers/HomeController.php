<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBuyerRequest;
use App\Models\Buyer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');

    }
    public function AbouteUs()
    {
        return view('Aboute.index');
    }
    public function export()
    {
        return view('export.index');
    }
    public function import(){
        return view('import.index');
    }
    public function logistics()
    {
        return view('Logistics.index');
    }
    public function markets()
    {
        return view('markets.index');
    }
 public function suppliers()
 {
        return view('suppliers.index');
 }
 public function buyer()
 {
     return view('buyers.index');
 }
    public function store(StoreBuyerRequest $request): RedirectResponse
    {
        // داده‌های اعتبارسنجی‌شده به‌صورت خودکار در دسترس هستند
        Buyer::create($request->validated());

        return redirect()
            ->route('buyer', ['locale' => app()->getLocale()])
            ->with('success', __('buyers.success_message'));
    }
    public function catalogs()
    {
        $locale = app()->getLocale();

        // کاتالوگ‌های فعال + ترجمه‌ی زبان جاری
        $catalogs = \App\Models\Catalog::query()
            ->where('is_active', true)
            ->with([
                'translations' => function ($q) use ($locale) {
                    $q->where('locale', $locale);
                },
            ])
            ->orderBy('sort_order')
            ->get()
            // فقط کاتالوگ‌هایی که ترجمه‌ی این زبان را دارند
            ->filter(fn ($catalog) => $catalog->translations->isNotEmpty());

        return view('catalogs.index', compact('catalogs', 'locale'));
    }
    public function contact()
    {
        return view('contactUs.index');
    }
    public function productExport()
    {
        return view('export.products');
    }
    public function gallery()
    {
        return view('gallery.index');
    }
    public function projects()
    {
        return view('projects.index');
    }
    public function services()
    {
        return view('services.index');
    }
}
