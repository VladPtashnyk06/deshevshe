<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $admins = User::where('role', 'admin')->get();
        $operators = User::where('role', 'operator')->get();
        $queryParams = $request->only(['name_and_last_name', 'phone', 'email', 'role']);
        $filteredParams = array_filter($queryParams);
        $query = User::query()->where('role', 'user');

        if (isset($filteredParams['name_and_last_name'])) {
            $query->orWhere('name', 'LIKE', '%' . $filteredParams['name_and_last_name'] . '%')->orWhere('last_name', 'LIKE', '%' . $filteredParams['name_and_last_name'] . '%');
        }

        if (isset($filteredParams['phone'])) {
            $query->where('phone', 'LIKE', '%' . $filteredParams['phone'] . '%');
        }

        if (isset($filteredParams['email'])) {
            $query->where('email', 'LIKE', '%' . $filteredParams['email'] . '%');
        }

        $users = $query->paginate(25);
        $usersAddresses = UserAddress::all();
        return view('admin.users.index', compact('admins', 'operators', 'users', 'usersAddresses'));
    }

    public function createOperator() {
        return view('admin.users.create-operator');
    }

    public function storeOperator(Request $request) {
        User::create([
            'name' => $request->post('name'),
            'last_name' => $request->post('name'),
            'password' => \Hash::make($request->post('password')),
            'role' => 'operator'
        ]);

        return redirect()->route('user.index');
    }

    /**
     * @param User $user
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(User $user) {
        $userAddress = UserAddress::where('user_id', $user->id)->first();
        return view('admin.users.edit', compact('user', 'userAddress'));
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
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

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user) {
        $user->delete();
        return back();
    }

    public function loginForOperator()
    {
        return view('auth.login-for-operator');
    }
}
