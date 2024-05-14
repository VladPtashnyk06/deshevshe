<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Http\Requests\MaterialRequest;
use App\Models\Color;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        return view('admin.materials.index', compact('materials'));
    }

    public function create() {
        return view('admin.materials.create');
    }

    public function store(MaterialRequest $request)
    {
        Material::create($request->validated());
        return redirect()->route('material.index');
    }

    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(MaterialRequest $request, Material $material)
    {
        $material->update($request->validated());

        return redirect()->route('material.index');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('material.index');
    }
}
