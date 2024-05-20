<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ColorController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create() {
        return view('admin.colors.create');
    }

    /**
     * @param ColorRequest $request
     * @return RedirectResponse
     */
    public function store(ColorRequest $request)
    {
        Color::create($request->validated());
        return redirect()->route('color.index');
    }

    /**
     * @param Color $color
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    /**
     * @param ColorRequest $request
     * @param Color $color
     * @return RedirectResponse
     */
    public function update(ColorRequest $request, Color $color)
    {
        $color->update($request->validated());

        return redirect()->route('color.index');
    }

    /**
     * @param Color $color
     * @return RedirectResponse
     */
    public function destroy(Color $color)
    {
        $color->delete();

        return redirect()->route('color.index');
    }
}
