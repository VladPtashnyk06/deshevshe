<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fashion;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FashionController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $fashions = Fashion::paginate(25);
        return view('admin.fashions.index', compact('fashions'));
    }

    /**
     * @param Fashion $fashion
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Fashion $fashion)
    {
        return view('admin.fashions.edit', compact('fashion'));
    }

    /**
     * @param Request $request
     * @param Fashion $fashion
     * @return RedirectResponse
     */
    public function update(Request $request, Fashion $fashion)
    {
        $fashion->update(['title' => $request->post('title')]);

        return redirect()->route('fashion.index');
    }

    /**
     * @param Fashion $fashion
     * @return RedirectResponse
     */
    public function destroy(Fashion $fashion)
    {
        $fashion->delete();

        return redirect()->route('fashion.index');
    }
}
