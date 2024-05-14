<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacteristicRequest;
use App\Models\Characteristic;

class CharacteristicController extends Controller
{
    public function index()
    {
        return Characteristic::all();
    }

    public function store(CharacteristicRequest $request)
    {
        return Characteristic::create($request->validated());
    }

    public function show(Characteristic $characteristic)
    {
        return $characteristic;
    }

    public function update(CharacteristicRequest $request, Characteristic $characteristic)
    {
        $characteristic->update($request->validated());

        return $characteristic;
    }

    public function destroy(Characteristic $characteristic)
    {
        $characteristic->delete();

        return response()->json();
    }
}
