<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MaterialController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $materials = Material::all();
        return view('admin.materials.index', compact('materials'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create() {
        return view('admin.materials.create');
    }

    /**
     * @param MaterialRequest $request
     * @return RedirectResponse
     */
    public function store(MaterialRequest $request)
    {
        Material::create($request->validated());
        return redirect()->route('material.index');
    }

    /**
     * @param Material $material
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    /**
     * @param MaterialRequest $request
     * @param Material $material
     * @return RedirectResponse
     */
    public function update(MaterialRequest $request, Material $material)
    {
        $material->update($request->validated());

        return redirect()->route('material.index');
    }

    /**
     * @param Material $material
     * @return RedirectResponse
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('material.index');
    }
}
