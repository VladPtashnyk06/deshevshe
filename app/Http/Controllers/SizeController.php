<?php

namespace App\Http\Controllers;

use App\Http\Requests\SizeRequest;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        return Size::all();
    }

    public function store(SizeRequest $request)
    {
        return Size::create($request->validated());
    }

    public function show(Size $size)
    {
        return $size;
    }

    public function update(SizeRequest $request, Size $size)
    {
        $size->update($request->validated());

        return $size;
    }

    public function destroy(Size $size)
    {
        $size->delete();

        return response()->json();
    }
}
