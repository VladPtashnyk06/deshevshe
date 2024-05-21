<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function getExchangeRatesByCurrency($currency)
    {
        $response = Http::get('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json');
        $data = $response->json();
        $filteredData = collect($data)->whereIn('cc', [$currency])->toArray();

        return $filteredData;
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function changeCurrency(Request $request)
    {
        $currency = $request->input('currency');

        $request->session()->put('currency', $currency);

        $usd = $this->getExchangeRatesByCurrency('USD');
        $eur = $this->getExchangeRatesByCurrency('EUR');
        foreach ($usd as $data) {
            $request->session()->put('currency_rate_usd', $data['rate']);
        }
        foreach ($eur as $data) {
            $request->session()->put('currency_rate_eur', $data['rate']);
        }
        return redirect()->back();
    }
}
