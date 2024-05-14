<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {
        $sub_categories = SubCategory::all();
        return view('admin.sub_categories.index', compact('sub_categories'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.sub_categories.create', compact('categories'));
    }

    public function store(SubCategoryRequest $request)
    {
        SubCategory::create($request->validated());
        return redirect()->route('sub_category.index');
    }

    public function edit(SubCategory $sub_category)
    {
        $categories = Category::all();
        return view('admin.sub_categories.edit', compact('sub_category', 'categories'));
    }

    public function update(SubCategoryRequest $request, SubCategory $sub_category)
    {
        $sub_category->update($request->validated());

        return redirect()->route('sub_category.index');
    }

    public function destroy(SubCategory $sub_category)
    {
        $sub_category->delete();

        return redirect()->route('sub_category.index');
    }
}
