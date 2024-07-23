<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FabricComposition;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FabricCompositionController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $fabricCompositions = FabricComposition::paginate(25);
        return view('admin.fabric-compositions.index', compact('fabricCompositions'));
    }

    /**
     * @param FabricComposition $fabricComposition
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(FabricComposition $fabricComposition)
    {
        return view('admin.fabric-compositions.edit', compact('fabricComposition'));
    }

    /**
     * @param Request $request
     * @param FabricComposition $fabricComposition
     * @return RedirectResponse
     */
    public function update(Request $request, FabricComposition $fabricComposition)
    {
        $fabricComposition->update(['title' => $request->post('title')]);

        return redirect()->route('fabric-composition.index');
    }

    /**
     * @param FabricComposition $fabricComposition
     * @return RedirectResponse
     */
    public function destroy(FabricComposition $fabricComposition)
    {
        $fabricComposition->delete();

        return redirect()->route('fabric-composition.index');
    }
}
