<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromoCodeRequest;
use App\Models\PromoCode;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::all();
        return view('admin.promoCodes.index', compact('promoCodes'));
    }

    public function create()
    {
        return view('admin.promoCodes.create');
    }

    public function store(PromoCodeRequest $request)
    {
        PromoCode::create($request->validated());
        return redirect()->route('promoCode.index');
    }

    public function edit(PromoCode $promoCode)
    {
        return view('admin.promoCodes.edit', compact('promoCode'));
    }

    public function update(PromoCodeRequest $request, PromoCode $promoCode)
    {
        $promoCode->update($request->validated());

        return redirect()->route('promoCode.index');
    }

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();

        return back();
    }
}
