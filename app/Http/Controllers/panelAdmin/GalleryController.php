<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $galleries = Gallery::query()
            ->with(['translations' => fn ($q) => $q->where('locale', $locale)])
            ->when($request->filled('activity_type'),
                fn ($q) => $q->ofType($request->string('activity_type')))
            ->when($request->filled('search'),
                fn ($q) => $q->search($request->string('search')))
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('panelAdmin.gallery.index', [
            'galleries'     => $galleries,
            'activityTypes' => Gallery::ACTIVITY_TYPES,
        ]);
    }

    public function create(): View
    {
        return view('panelAdmin.gallery.create', [
            'activityTypes' => Gallery::ACTIVITY_TYPES,
            'locales'       => Gallery::LOCALES,
        ]);
    }

    public function store(StoreGalleryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($request, &$data) {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('galleries', 'public');
            }

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            $gallery = Gallery::create($data);

            $this->saveTranslations($gallery, $translations);
        });

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', __('gallery.created'));
    }

    public function show(Gallery $gallery): View
    {
        $gallery->load('translations');

        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery): View
    {
        $gallery->load('translations');

        return view('panelAdmin.gallery.edit', [
            'gallery'       => $gallery,
            'activityTypes' => Gallery::ACTIVITY_TYPES,
            'locales'       => Gallery::LOCALES,
        ]);
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($request, $gallery, &$data) {
            if ($request->hasFile('image')) {
                if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                    Storage::disk('public')->delete($gallery->image);
                }
                $data['image'] = $request->file('image')->store('galleries', 'public');
            } else {
                unset($data['image']);
            }

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            $gallery->update($data);

            $this->saveTranslations($gallery, $translations);
        });

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', __('gallery.updated'));
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', __('gallery.deleted'));
    }

    /**
     * ذخیره ترجمه‌ها
     */
    protected function saveTranslations(Gallery $gallery, array $translations): void
    {
        foreach ($translations as $locale => $values) {
            // اگر عنوان خالی است، از ترجمه زبان پیش‌فرض پر کن
            if (empty($values['title'])) {
                continue;
            }

            // تولید slug در صورت خالی بودن
            if (empty($values['slug'])) {
                $values['slug'] = Gallery::generateUniqueSlug(
                    $values['title'],
                    $locale,
                    $gallery->id
                );
            }

            $gallery->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title'       => $values['title'],
                    'slug'        => $values['slug'],
                    'description' => $values['description'] ?? null,
                    'alt_text'    => $values['alt_text'] ?? null,
                ]
            );
        }
    }
}
