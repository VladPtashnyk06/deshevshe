<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;

class UserAddressController extends Controller
{
    public function index()
    {
        return UserAddress::all();
    }

    public function store(UserAddressRequest $request)
    {
        return UserAddress::create($request->validated());
    }

    public function show(UserAddress $userAddress)
    {
        return $userAddress;
    }

    public function update(UserAddressRequest $request, UserAddress $userAddress)
    {
        $userAddress->update($request->validated());

        return $userAddress;
    }

    public function destroy(UserAddress $userAddress)
    {
        $userAddress->delete();

        return response()->json();
    }
}
