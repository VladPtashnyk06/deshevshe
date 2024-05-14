<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {
        return SubCategory::all();
    }

    public function store(SubCategoryRequest $request)
    {
        return SubCategory::create($request->validated());
    }

    public function show(SubCategory $subCategory)
    {
        return $subCategory;
    }

    public function update(SubCategoryRequest $request, SubCategory $subCategory)
    {
        $subCategory->update($request->validated());

        return $subCategory;
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        return response()->json();
    }
}
