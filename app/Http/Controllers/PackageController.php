<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('admin.packages.index', compact('packages'));
    }

    public function create() {
        return view('admin.packages.create');
    }

    public function store(PackageRequest $request)
    {
        Package::create($request->validated());
        return redirect()->route('package.index');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(PackageRequest $request, Package $package)
    {
        $package->update($request->validated());

        return redirect()->route('package.index');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('package.index');
    }
}
