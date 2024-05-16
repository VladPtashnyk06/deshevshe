<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequest;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }

    public function create() {
        return view('admin.sizes.create');
    }

    public function store(SizeRequest $request)
    {
        Size::create($request->validated());
        return redirect()->route('size.index');
    }

    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(SizeRequest $request, Size $size)
    {
        $size->update($request->validated());

        return redirect()->route('size.index');
    }

    public function destroy(Size $size)
    {
        $size->delete();

        return redirect()->route('size.index');
    }
}
