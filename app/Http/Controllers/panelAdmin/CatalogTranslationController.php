<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\CatalogTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogTranslationController extends Controller
{
    /**
     * Display translations.
     */


    public function index(Catalog $catalog)
    {
        $translations = $catalog->translations()
            ->latest()
            ->get();

        return view(
            'panelAdmin.catalog.catalogTranslation.index',
            compact('catalog', 'translations')
        );
    }


    /**
     * Show create form.
     */
    public function create(Catalog $catalog)
    {
        return view(
            'panelAdmin.catalog.catalogTranslation.create',
            compact('catalog')
        );
    }


    /**
     * Store translation.
     */
    public function store(
        Request $request,
        Catalog $catalog
    ) {

        $validated = $request->validate([

            'locale' => [
                'required',
                'in:fa,en,ar',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'file' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:100000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate language
        |--------------------------------------------------------------------------
        */

        $exists = $catalog->translations()
            ->where('locale', $validated['locale'])
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->withErrors([
                    'locale' =>
                        'این زبان قبلاً برای این کاتالوگ ثبت شده است.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Prepare data
        |--------------------------------------------------------------------------
        */

        $data = [
            'locale' => $validated['locale'],

            'title' => $validated['title'],

            'description' =>
                $validated['description'] ?? null,
        ];


        /*
        |--------------------------------------------------------------------------
        | Upload PDF
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $path = $file->store(
                'catalogs/' . $validated['locale'],
                'public'
            );

            $data['file_path'] = $path;

            $data['file_name'] =
                $file->getClientOriginalName();

            $data['file_size'] =
                $file->getSize();
        }


        /*
        |--------------------------------------------------------------------------
        | Create translation
        |--------------------------------------------------------------------------
        */

        $catalog->translations()->create($data);


        return redirect()
            ->route(
                'admin.catalog.translation.index',
                $catalog
            )
            ->with(
                'success',
                __('catalogs.translation_created')
            );
    }


    /**
     * Show edit form.
     */
    public function edit(
        Catalog $catalog,
        CatalogTranslation $translation
    ) {

        abort_unless(
            $translation->catalog_id === $catalog->id,
            404
        );


        return view(
            'panelAdmin.catalog.catalogTranslation.edit',
            compact(
                'catalog',
                'translation'
            )
        );
    }


    /**
     * Update translation.
     */
    public function update(
        Request $request,
        Catalog $catalog,
        CatalogTranslation $translation
    ) {

        abort_unless(
            $translation->catalog_id === $catalog->id,
            404
        );


        $validated = $request->validate([

            'locale' => [
                'required',
                'in:fa,en,ar',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'file' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:20480',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Check duplicate locale
        |--------------------------------------------------------------------------
        */

        $duplicate = $catalog->translations()
            ->where('locale', $validated['locale'])
            ->where('id', '!=', $translation->id)
            ->exists();

        if ($duplicate) {

            return back()
                ->withInput()
                ->withErrors([
                    'locale' =>
                        'این زبان قبلاً برای این کاتالوگ ثبت شده است.'
                ]);
        }


        $translation->locale =
            $validated['locale'];

        $translation->title =
            $validated['title'];

        $translation->description =
            $validated['description'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | Replace PDF
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file')) {

            if (
                $translation->file_path &&
                Storage::disk('public')
                    ->exists($translation->file_path)
            ) {

                Storage::disk('public')
                    ->delete(
                        $translation->file_path
                    );
            }


            $file =
                $request->file('file');


            $path = $file->store(
                'catalogs/' . $validated['locale'],
                'public'
            );


            $translation->file_path =
                $path;

            $translation->file_name =
                $file->getClientOriginalName();

            $translation->file_size =
                $file->getSize();
        }


        $translation->save();


        return redirect()
            ->route(
                'admin.catalog.translation.index',
                $catalog
            )
            ->with(
                'success',
                __('catalogs.translation_updated')
            );
    }


    /**
     * Delete translation.
     */
    public function destroy(Catalog $catalog, CatalogTranslation $translation)
    {
        abort_unless($translation->catalog_id === $catalog->id, 404);

        if ($translation->file_path && Storage::disk('public')->exists($translation->file_path)) {
            Storage::disk('public')->delete($translation->file_path);
        }

        $translation->delete();

        return redirect()
            ->route('admin.catalog.translation.index', $catalog)
            ->with('success', 'ترجمه با موفقیت حذف شد.');
    }

}
