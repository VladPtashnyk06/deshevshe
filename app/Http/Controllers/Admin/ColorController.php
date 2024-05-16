<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }

    public function create() {
        return view('admin.colors.create');
    }

    public function store(ColorRequest $request)
    {
        Color::create($request->validated());
        return redirect()->route('color.index');
    }

    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(ColorRequest $request, Color $color)
    {
        $color->update($request->validated());

        return redirect()->route('color.index');
    }

    public function destroy(Color $color)
    {
        $color->delete();

        return redirect()->route('color.index');
    }
}
