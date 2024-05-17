<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Models\Package;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PackageController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $packages = Package::all();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create() {
        return view('admin.packages.create');
    }

    /**
     * @param PackageRequest $request
     * @return RedirectResponse
     */
    public function store(PackageRequest $request)
    {
        Package::create($request->validated());
        return redirect()->route('package.index');
    }

    /**
     * @param Package $package
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * @param PackageRequest $request
     * @param Package $package
     * @return RedirectResponse
     */
    public function update(PackageRequest $request, Package $package)
    {
        $package->update($request->validated());

        return redirect()->route('package.index');
    }

    /**
     * @param Package $package
     * @return RedirectResponse
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('package.index');
    }
}
