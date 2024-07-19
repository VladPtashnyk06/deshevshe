<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Category::query();

        $filter = false;

        if ($request->filled('id')) {
            $filter = true;
            $query->where('id', $request->input('id'));
        }

        if ($request->filled('title')) {
            $filter = true;
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->filled('level')) {
            $filter = true;
            $query->where('level', $request->input('level'));
        }

        $filterCategories = $query->get();
        foreach ($filterCategories as $category) {
            $category->title = $this->buildCategoryChain($category);
        }
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('admin.categories.index', compact('categories', 'filterCategories', 'filter'));
    }

    /**
     * @param Category $category
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function createSubCategory(Category $category)
    {
        $categoryChain = $this->buildCategoryChain($category);
        return view('admin.categories.createSubCategory', compact('category', 'categoryChain'));
    }

    private function buildCategoryChain(Category $category)
    {
        $chain = [];
        while ($category) {
            array_unshift($chain, $category->title);
            $category = $category->parent;
        }
        return implode(' > ', $chain);
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create() {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('category.index');
    }

    /**
     * @param Category $category
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        if ($request->validated('main_media_id')) {
            $media = Media::find($request->validated('main_media_id'));
            $media->collection_name = 'category'.$category->id;
            $media->custom_properties = [
                'alt' => $category->title,
            ];
            $media->save();
        }
        if ($request->validated('deleted_main_image')) {
            $idDeletedPoster = $request->validated('deleted_main_image');
            Media::find($idDeletedPoster)->delete();
        }

        if ($request->validated('main_image')) {
            $category->addMedia($request->validated('main_image'))->withCustomProperties([
                'alt' => $category->title,
            ])->toMediaCollection('category'.$category->id);
        }

        return redirect()->route('category.index');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index');
    }
}
