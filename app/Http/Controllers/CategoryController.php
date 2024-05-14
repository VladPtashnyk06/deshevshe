<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Categorie;

class CategoryController extends Controller
{
    public function index()
    {
        return Categorie::all();
    }

    public function store(CategoryRequest $request)
    {
        return Categorie::create($request->validated());
    }

    public function show(Categorie $category)
    {
        return $category;
    }

    public function update(CategoryRequest $request, Categorie $category)
    {
        $category->update($request->validated());

        return $category;
    }

    public function destroy(Categorie $category)
    {
        $category->delete();

        return response()->json();
    }
}
