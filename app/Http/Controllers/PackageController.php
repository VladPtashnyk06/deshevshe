<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        return Package::all();
    }

    public function store(PackageRequest $request)
    {
        return Package::create($request->validated());
    }

    public function show(Package $package)
    {
        return $package;
    }

    public function update(PackageRequest $request, Package $package)
    {
        $package->update($request->validated());

        return $package;
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return response()->json();
    }
}
