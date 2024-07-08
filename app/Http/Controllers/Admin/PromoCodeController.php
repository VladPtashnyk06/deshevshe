<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromoCodeRequest;
use App\Models\Category;
use App\Models\Price;
use App\Models\Producer;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\User;
use App\Models\UserPromocode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::all();
        return view('admin.promoCodes.index', compact('promoCodes'));
    }

    public function addPromoCode(Request $request, PromoCode $promoCode)
    {
        $queryParams = $request->only(['user_name', 'user_last_name', 'user_phone', 'user_gmail', 'promocod_status']);
        $filteredParams = array_filter($queryParams);
        $query = User::where('role', '=', 'user');

        if (isset($filteredParams['user_name'])) {
            $query->where('name', 'LIKE', '%' . $filteredParams['user_name'] . '%');
        }

        if (isset($filteredParams['user_last_name'])) {
            $query->where('last_name', 'LIKE', '%' . $filteredParams['user_last_name'] . '%');
        }

        if (isset($filteredParams['user_phone'])) {
            $query->where('phone', 'LIKE', '%' . $filteredParams['user_phone'] . '%');
        }

        if (isset($filteredParams['user_gmail'])) {
            $query->where('email', 'LIKE', '%' . $filteredParams['user_gmail'] . '%');
        }

        if (isset($filteredParams['promocod_status'])) {
            if ($filteredParams['promocod_status'] == 'Використанний') {
                $query->whereHas('promocodes', function ($q) use ($promoCode) {
                    $q->where('promo_code_id', $promoCode->id)->where('status', 'Використанний');
                });
            } elseif ($filteredParams['promocod_status'] == 'Не використанний') {
                $query->whereHas('promocodes', function ($q) use ($promoCode) {
                    $q->where('promo_code_id', $promoCode->id)->where('status', 'Не використанний');
                });
            } elseif ($filteredParams['promocod_status'] == 'Немає') {
                $query->whereDoesntHave('promocodes', function ($q) use ($promoCode) {
                    $q->where('promo_code_id', $promoCode->id);
                });
            }
        }

        $users = $query->get();

        return view('admin.promoCodes.add-promo-code-user', compact('promoCode', 'users'));
    }

    public function storePromoCodeForUser(Request $request, PromoCode $promoCode)
    {
        UserPromoCode::create([
            'user_id' => $request->post('user_id'),
            'promo_code_id' => $promoCode->id,
        ]);

        return back();
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

    public function destroyUserPromoCode(Request $request, PromoCode $promoCode)
    {
        $userPromoCode = UserPromoCode::where('promo_code_id', $promoCode->id)->where('user_id', $request->post('user_id'))->first();
        if ($userPromoCode) {
            $userPromoCode->delete();
        }

        return back();
    }
}
