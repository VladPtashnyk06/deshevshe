<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CharacteristicRequest;
use App\Models\Characteristic;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CharacteristicController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $characteristics = Characteristic::paginate(25);
        return view('admin.characteristics.index', compact('characteristics'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create() {
        return view('admin.characteristics.create');
    }

    /**
     * @param CharacteristicRequest $request
     * @return RedirectResponse
     */
    public function store(CharacteristicRequest $request)
    {
        Characteristic::create($request->validated());
        return redirect()->route('characteristic.index');
    }

    /**
     * @param Characteristic $characteristic
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Characteristic $characteristic)
    {
        return view('admin.characteristics.edit', compact('characteristic'));
    }

    /**
     * @param CharacteristicRequest $request
     * @param Characteristic $characteristic
     * @return RedirectResponse
     */
    public function update(CharacteristicRequest $request, Characteristic $characteristic)
    {
        $characteristic->update($request->validated());

        return redirect()->route('characteristic.index');
    }

    /**
     * @param Characteristic $characteristic
     * @return RedirectResponse
     */
    public function destroy(Characteristic $characteristic)
    {
        $characteristic->delete();

        return redirect()->route('characteristic.index');
    }
}
