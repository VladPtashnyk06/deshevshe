<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CharacteristicRequest;
use App\Models\Characteristic;

class CharacteristicController extends Controller
{
    public function index()
    {
        $characteristics = Characteristic::all();
        return view('admin.characteristics.index', compact('characteristics'));
    }

    public function create() {
        return view('admin.characteristics.create');
    }

    public function store(CharacteristicRequest $request)
    {
        Characteristic::create($request->validated());
        return redirect()->route('characteristic.index');
    }

    public function edit(Characteristic $characteristic)
    {
        return view('admin.characteristics.edit', compact('characteristic'));
    }

    public function update(CharacteristicRequest $request, Characteristic $characteristic)
    {
        $characteristic->update($request->validated());

        return redirect()->route('characteristic.index');
    }

    public function destroy(Characteristic $characteristic)
    {
        $characteristic->delete();

        return redirect()->route('characteristic.index');
    }
}
