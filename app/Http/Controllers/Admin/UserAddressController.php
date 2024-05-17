<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use LaravelIdea\Helper\App\Models\_IH_UserAddress_C;

class UserAddressController extends Controller
{
    /**
     * @return UserAddress[]|Collection|_IH_UserAddress_C
     */
    public function index()
    {
        return UserAddress::all();
    }

    /**
     * @param UserAddressRequest $request
     * @return UserAddress
     */
    public function store(UserAddressRequest $request)
    {
        return UserAddress::create($request->validated());
    }

    /**
     * @param UserAddress $userAddress
     * @return UserAddress
     */
    public function show(UserAddress $userAddress)
    {
        return $userAddress;
    }

    /**
     * @param UserAddressRequest $request
     * @param UserAddress $userAddress
     * @return UserAddress
     */
    public function update(UserAddressRequest $request, UserAddress $userAddress)
    {
        $userAddress->update($request->validated());

        return $userAddress;
    }

    /**
     * @param UserAddress $userAddress
     * @return JsonResponse
     */
    public function destroy(UserAddress $userAddress)
    {
        $userAddress->delete();

        return response()->json();
    }
}
