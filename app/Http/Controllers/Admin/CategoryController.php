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

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $uniqueParentIds = $categories->pluck('parent_id')->unique()->filter();
        $parentCategories = Category::whereIn('id', $uniqueParentIds)->get();
        $uniqueLevels = $categories->pluck('level')->unique();

        $queryParams = $request->only(['parent_category', 'level']);
        $filteredParams = array_filter($queryParams);

        $query = Category::query();

        if (isset($filteredParams['parent_category'])) {
            if ($filteredParams['parent_category'] == 'null') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $filteredParams['parent_category']);
            }
        }

        if (isset($filteredParams['level'])) {
            $query->where('level', $filteredParams['level']);
        }

        $categories = $query->get();

        return view('admin.categories.index', compact('categories', 'uniqueLevels', 'parentCategories'));
    }

    /**
     * @param Category $category
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function createSubCategory(Category $category)
    {
        return view('admin.categories.createSubCategory', compact('category'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create() {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        if (!$request->validated('parent_id') == null) {
            $parentCategory = Category::findOrFail($request->validated('parent_id'));
            Category::create([
                'title' => $request->validated('title'),
                'parent_id' => $request->validated('parent_id'),
                'level' => $parentCategory->level + 1,
            ]);
        } else {
            Category::create($request->validated());
        }
        return redirect()->route('category.index');
    }

    /**
     * @param Category $category
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

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
