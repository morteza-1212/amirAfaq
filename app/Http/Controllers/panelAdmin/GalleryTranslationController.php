<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryTranslationRequest;
use App\Http\Requests\UpdateGalleryTranslationRequest;
use App\Models\Gallery;
use App\Models\GalleryTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GalleryTranslationController extends Controller
{
    /**
     * لیست ترجمه‌های یک گالری
     */
    public function index(Gallery $gallery): View
    {
        $translations = $gallery->translations()
            ->orderBy('locale')
            ->paginate(15);

        return view('panelAdmin.gallery.galleryTranslation.index', [
            'gallery'      => $gallery,
            'translations' => $translations,
            'locales'      => Gallery::LOCALES,
        ]);
    }

    /**
     * فرم ایجاد ترجمه جدید
     */
    public function create(Gallery $gallery): View
    {
        // زبان‌هایی که هنوز ترجمه ندارند
        $usedLocales = $gallery->translations()->pluck('locale')->toArray();
        $availableLocales = array_diff_key(Gallery::LOCALES, array_flip($usedLocales));

        return view('panelAdmin.gallery.galleryTranslation.create', [
            'gallery'          => $gallery,
            'availableLocales' => $availableLocales,
        ]);
    }

    /**
     * ذخیره ترجمه جدید
     */
    public function store(StoreGalleryTranslationRequest $request, Gallery $gallery): RedirectResponse
    {
        $data = $request->validated();

        // تولید خودکار slug در صورت خالی بودن
        if (empty($data['slug'])) {
            $data['slug'] = Gallery::generateUniqueSlug(
                $data['title'],
                $data['locale']
            );
        }

        $gallery->translations()->create($data);

        return redirect()
            ->route('admin.gallery.translations.index', $gallery)
            ->with('success', __('gallery.translation_created'));
    }

    /**
     * نمایش یک ترجمه (اختیاری - اگر نخواستی می‌توانی حذف کنی)
     */
    public function show(Gallery $gallery, GalleryTranslation $galleryTranslation): View
    {
        $this->ensureBelongsToGallery($gallery, $galleryTranslation);

        return view('panelAdmin.galleries.translations.show', [
            'gallery'     => $gallery,
            'translation' => $galleryTranslation,
        ]);
    }

    /**
     * فرم ویرایش ترجمه
     */
    public function edit(Gallery $gallery, GalleryTranslation $galleryTranslation): View
    {
        $this->ensureBelongsToGallery($gallery, $galleryTranslation);

        return view('panelAdmin.gallery.galleryTranslation.edit', [
            'gallery'     => $gallery,
            'translation' => $galleryTranslation,
            'locales'     => Gallery::LOCALES,
        ]);
    }

    /**
     * به‌روزرسانی ترجمه
     */
    public function update(
        UpdateGalleryTranslationRequest $request,
        Gallery $gallery,
        GalleryTranslation $galleryTranslation
    ): RedirectResponse {
        $this->ensureBelongsToGallery($gallery, $galleryTranslation);

        $data = $request->validated();

        // اگر slug خالی مانده، از title جدید بساز
        if (empty($data['slug'])) {
            $data['slug'] = Gallery::generateUniqueSlug(
                $data['title'],
                $data['locale'],
                $galleryTranslation->id
            );
        }

        $galleryTranslation->update($data);

        return redirect()
            ->route('admin.gallery.translations.index', $gallery)
            ->with('success', __('gallery.translation_updated'));
    }

    /**
     * حذف ترجمه
     */
    public function destroy(Gallery $gallery, GalleryTranslation $galleryTranslation): RedirectResponse
    {
        $this->ensureBelongsToGallery($gallery, $galleryTranslation);

        // جلوگیری از حذف آخرین ترجمه زبان پیش‌فرض
        if ($galleryTranslation->locale === Gallery::DEFAULT_LOCALE) {
            return back()->with('error', __('gallery.cannot_delete_default_locale'));
        }

        $galleryTranslation->delete();

        return redirect()
            ->route('admin.gallery.translations.index', $gallery)
            ->with('success', __('gallery.translation_deleted'));
    }

    /**
     * اطمینان از اینکه ترجمه به این گالری تعلق دارد
     */
    protected function ensureBelongsToGallery(Gallery $gallery, GalleryTranslation $translation): void
    {
        abort_if($translation->gallery_id !== $gallery->id, 404);
    }
}
