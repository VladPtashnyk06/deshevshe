<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        return Color::all();
    }

    public function store(ColorRequest $request)
    {
        return Color::create($request->validated());
    }

    public function show(Color $colors)
    {
        return $colors;
    }

    public function update(ColorRequest $request, Color $colors)
    {
        $colors->update($request->validated());

        return $colors;
    }

    public function destroy(Color $colors)
    {
        $colors->delete();

        return response()->json();
    }
}
