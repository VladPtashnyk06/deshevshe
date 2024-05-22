<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeCurrencyRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function changeCurrency()
    {
        return redirect()->back();
    }
}
