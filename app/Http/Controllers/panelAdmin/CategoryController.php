<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\ProductGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /* ============================================================
     |  Index
     ============================================================ */
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->with(['translations', 'parent.translations', 'productGroup'])
            ->when($request->filled('search'),
                fn ($q) => $q->search($request->string('search')))
            ->when($request->filled('group'),
                fn ($q) => $q->ofGroup($request->integer('group')))
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->string('status') === 'active');
            })
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        $groups = ProductGroup::with('translations')->orderBy('sort_order')->get();
        return view('panelAdmin.category.index', compact('categories', 'groups'));
    }

    /* ============================================================
     |  Create
     ============================================================ */
    public function create(): View
    {
        $groups = ProductGroup::with('translations')->orderBy('sort_order')->get();        $parents   = Category::with('translations')->ordered()->get();

        return view('panelAdmin.category.create', compact('groups', 'parents'));
    }

    /* ============================================================
     |  Store
     ============================================================ */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $category = null;

        DB::transaction(function () use ($request, &$data, &$category) {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('categories', 'public');
            }

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            // کد خودکار در Model ساخته می‌شود
            $category = Category::create($data);

            $this->saveTranslations($category, $translations);
        });

        return redirect()
            ->route('admin.category.index')
            ->with('success', 'دسته‌بندی با موفقیت ایجاد شد. کد: ' . $category->code);
    }

    /* ============================================================
     |  Show
     ============================================================ */
    public function show(Category $category): View
    {
        $category->load(['translations', 'parent.translations', 'productGroup']);

        return view('panelAdmin.category.show', compact('category'));
    }

    /* ============================================================
     |  Edit
     ============================================================ */
    public function edit(Category $category): View
    {
        $category->load(['translations', 'parent.translations', 'productGroup']);

        $groups = ProductGroup::with('translations')->orderBy('sort_order')->get();
        // دسته‌های قابل انتخاب به‌عنوان والد
        // (خود دسته و فرزندانش نباید نمایش داده شوند)
        $descendantIds = $this->getDescendantIds($category);

        $parents = Category::with('translations')
            ->where('id', '!=', $category->id)
            ->whereNotIn('id', $descendantIds)
            ->ordered()
            ->get();

        return view('panelAdmin.category.edit', compact('category', 'groups', 'parents'));
    }

    /* ============================================================
     |  Update
     ============================================================ */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($request, $category, &$data) {
            if ($request->hasFile('image')) {
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }
                $data['image'] = $request->file('image')->store('categories', 'public');
            } else {
                unset($data['image']);
            }

            // code نباید تغییر کند
            unset($data['code']);

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            $category->update($data);

            $this->saveTranslations($category, $translations);
        });

        return redirect()
            ->route('admin.category.index')
            ->with('success', 'دسته‌بندی با موفقیت به‌روزرسانی شد.');
    }

    /* ============================================================
     |  Destroy
     ============================================================ */
    public function destroy(Category $category): RedirectResponse
    {
        // جلوگیری از حذف اگر فرزند دارد
        if ($category->children()->exists()) {
            return back()->with('error', 'ابتدا باید زیردسته‌ها را حذف یا منتقل کنید.');
        }

        DB::transaction(function () use ($category) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();
        });

        return redirect()
            ->route('admin.category.index')
            ->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }

    /* ============================================================
     |  Helper: Save Translations
     ============================================================ */
    protected function saveTranslations(Category $category, array $translations): void
    {
        foreach ($translations as $locale => $values) {
            if (empty($values['name'])) {
                continue;
            }

            if (empty($values['slug'])) {
                $values['slug'] = Category::generateUniqueSlug(
                    $values['name'],
                    $locale,
                    $category->id
                );
            }

            $category->translations()->updateOrCreate(
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

    /**
     * آی‌دی همه‌ی فرزندان (چند سطحی) برای جلوگیری از انتخاب به‌عنوان والد
     */
    protected function getDescendantIds(Category $category): array
    {
        $ids = [];
        $stack = [$category->id];

        while (! empty($stack)) {
            $parentId = array_pop($stack);
            $children = Category::where('parent_id', $parentId)->pluck('id')->toArray();

            foreach ($children as $childId) {
                $ids[] = $childId;
                $stack[] = $childId;
            }
        }

        return $ids;
    }
}
