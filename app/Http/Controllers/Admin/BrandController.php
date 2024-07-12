<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $brands = Brand::paginate(25);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * @param Brand $brand
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * @param Request $request
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function update(Request $request, Brand $brand)
    {
        $brand->update(['title' => $request->post('title')]);

        return redirect()->route('brand.index');
    }

    /**
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brand.index');
    }
}
