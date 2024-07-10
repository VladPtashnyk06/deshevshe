<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequest;
use App\Models\Size;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SizeController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $sizes = Size::paginate(25);
        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create() {
        return view('admin.sizes.create');
    }

    /**
     * @param SizeRequest $request
     * @return RedirectResponse
     */
    public function store(SizeRequest $request)
    {
        Size::create($request->validated());
        return redirect()->route('size.index');
    }

    /**
     * @param Size $size
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    /**
     * @param SizeRequest $request
     * @param Size $size
     * @return RedirectResponse
     */
    public function update(SizeRequest $request, Size $size)
    {
        $size->update($request->validated());

        return redirect()->route('size.index');
    }

    /**
     * @param Size $size
     * @return RedirectResponse
     */
    public function destroy(Size $size)
    {
        $size->delete();

        return redirect()->route('size.index');
    }
}
