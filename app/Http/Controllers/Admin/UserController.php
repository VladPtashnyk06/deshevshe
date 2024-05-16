<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request  $request)
    {
        $users = User::all();
        $queryParams = $request->only(['name_and_last_name', 'phone', 'email', 'role']);
        $filteredParams = array_filter($queryParams);
        $query = User::query();

        if (isset($filteredParams['name_and_last_name'])) {
            $query->orWhere('name', 'LIKE', '%' . $filteredParams['name_and_last_name'] . '%')->orWhere('last_name', 'LIKE', '%' . $filteredParams['name_and_last_name'] . '%');
        }

        if (isset($filteredParams['phone'])) {
            $query->where('phone', 'LIKE', '%' . $filteredParams['phone'] . '%');
        }

        if (isset($filteredParams['email'])) {
            $query->where('email', 'LIKE', '%' . $filteredParams['email'] . '%');
        }

        if (isset($filteredParams['role'])) {
            $query->where('role', $filteredParams['role']);
        }

        $users = $query->get();
        $usersAddresses = UserAddress::all();
        return view('admin.users.index', compact('users', 'usersAddresses'));
    }

    public function edit(User $user) {
        $userAddress = UserAddress::where('user_id', $user->id)->first();
        return view('admin.users.edit', compact('user', 'userAddress'));
    }

    public function update(UserRequest $request, User $user) {
        $user->update($request->validated());
        if (!empty($request->validated('region')) || !empty($request->validated('city')) || !empty($request->validated('address'))) {
            UserAddress::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'region' => $request->validated('region'),
                    'city' => $request->validated('city'),
                    'address' => $request->validated('address'),
                ]
            );
        }
        return redirect()->route('user.index');
    }

    public function destroy(User $user) {
        $user->delete();
        return back();
    }
}
