<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Style;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StyleController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $styles = Style::paginate(25);
        return view('admin.styles.index', compact('styles'));
    }

    /**
     * @param Style $style
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Style $style)
    {
        return view('admin.styles.edit', compact('style'));
    }

    /**
     * @param Request $request
     * @param Style $style
     * @return RedirectResponse
     */
    public function update(Request $request, Style $style)
    {
        $style->update(['title' => $request->post('title')]);

        return redirect()->route('style.index');
    }

    /**
     * @param Style $style
     * @return RedirectResponse
     */
    public function destroy(Style $style)
    {
        $style->delete();

        return redirect()->route('style.index');
    }
}
