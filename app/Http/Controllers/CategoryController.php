<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $uniqueParentIds = Category::select('parent_id')->distinct()->pluck('parent_id');
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

        return view('admin.categories.index', compact('categories', 'uniqueLevels', 'uniqueParentIds'));
    }

    public function createSubCategory(Category $category)
    {
        return view('admin.categories.createSubCategory', compact('category'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
    }

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

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('category.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index');
    }
}
