<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index()
    {
        return Material::all();
    }

    public function store(MaterialRequest $request)
    {
        return Material::create($request->validated());
    }

    public function show(Material $material)
    {
        return $material;
    }

    public function update(MaterialRequest $request, Material $material)
    {
        $material->update($request->validated());

        return $material;
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return response()->json();
    }
}
