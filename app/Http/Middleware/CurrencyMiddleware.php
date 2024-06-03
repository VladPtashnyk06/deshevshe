<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CurrencyMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $usd = $this->getExchangeRatesByCurrency('USD');
        $eur = $this->getExchangeRatesByCurrency('EUR');
        foreach ($usd as $data) {
            Session::put('currency_rate_usd', $data['rate']);
        }
        foreach ($eur as $data) {
            Session::put('currency_rate_eur', $data['rate']);
        }
        if (Session::has('currency')) {
            if ($request->has('currency')) {
                $currency = $request->input('currency');
                Session::put('currency', $currency);

                if ($currency == 'USD') {
                    $currency_rate_usd = session()->get('currency_rate_usd');
                    $this->updateCartPricesUSD($currency_rate_usd);
                } elseif ($currency == 'EUR') {
                    $currency_rate_eur = session()->get('currency_rate_eur');
                    $this->updateCartPricesEUR($currency_rate_eur);
                } elseif ($currency == 'UAH') {
                    $this->updateCartPricesUAH();
                }
            }
        } else {
            Session::put('currency', 'UAH');
            $this->updateCartPricesUAH();
        }

        return $next($request);
    }

    public function getExchangeRatesByCurrency($currency)
    {
        $response = Http::get('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json');
        $data = $response->json();
        $filteredData = collect($data)->whereIn('cc', [$currency])->toArray();

        return $filteredData;
    }

    protected function updateCartPricesEUR($currency_rate_eur)
    {
        $cart = \Cart::getContent();
        foreach ($cart as $item) {
            if ($item->attributes->currency == 'USD') {
                $this->resetCartPrices($item);
                $originalPrice = $item->attributes->pair;
                $product = Product::find($item->attributes->product_id);
                $color = $item->attributes->color;
                $size = $item->attributes->size;
                $product_quantity = $item->attributes->product_quantity;
                $imageUrl = $product->getFirstMediaUrl($product->id);
                \Cart::update($item->id, [
                    'price' => $originalPrice / $currency_rate_eur,
                    'attributes' => [
                        'product_id' => $product->id,
                        'code' => $product->code,
                        'color' => $color,
                        'size' => $size,
                        'product_quantity' => $product_quantity,
                        'pair' => $originalPrice,
                        'currency' => Session::get('currency'),
                        'imageUrl' => $imageUrl,
                    ],
                ]);
            } elseif ($item->attributes->currency == 'UAH') {
                $originalPrice = $item->attributes->pair;
                $product = Product::find($item->attributes->product_id);
                $color = $item->attributes->color;
                $size = $item->attributes->size;
                $product_quantity = $item->attributes->product_quantity;
                $imageUrl = $product->getFirstMediaUrl($product->id);
                \Cart::update($item->id, [
                    'price' => $originalPrice / $currency_rate_eur,
                    'attributes' => [
                        'product_id' => $product->id,
                        'code' => $product->code,
                        'color' => $color,
                        'size' => $size,
                        'product_quantity' => $product_quantity,
                        'pair' => $originalPrice,
                        'currency' => Session::get('currency'),
                        'imageUrl' => $imageUrl,
                    ],
                ]);
            }
        }
    }

    protected function updateCartPricesUSD($currency_rate_usd)
    {
        $cart = \Cart::getContent();
        foreach ($cart as $item) {
            if ($item->attributes->currency == 'EUR') {
                $this->resetCartPrices($item);
                $originalPrice = $item->attributes->pair;
                $product = Product::find($item->attributes->product_id);
                $color = $item->attributes->color;
                $size = $item->attributes->size;
                $product_quantity = $item->attributes->product_quantity;
                $imageUrl = $product->getFirstMediaUrl($product->id);
                \Cart::update($item->id, [
                    'price' => $originalPrice / $currency_rate_usd,
                    'attributes' => [
                        'product_id' => $product->id,
                        'code' => $product->code,
                        'color' => $color,
                        'size' => $size,
                        'product_quantity' => $product_quantity,
                        'pair' => $originalPrice,
                        'currency' => Session::get('currency'),
                        'imageUrl' => $imageUrl,
                    ],
                ]);
            } elseif ($item->attributes->currency == 'UAH') {
                $originalPrice = $item->attributes->pair;
                $product = Product::find($item->attributes->product_id);
                $color = $item->attributes->color;
                $size = $item->attributes->size;
                $product_quantity = $item->attributes->product_quantity;
                $imageUrl = $product->getFirstMediaUrl($product->id);
                \Cart::update($item->id, [
                    'price' => $originalPrice / $currency_rate_usd,
                    'attributes' => [
                        'product_id' => $product->id,
                        'code' => $product->code,
                        'color' => $color,
                        'size' => $size,
                        'product_quantity' => $product_quantity,
                        'pair' => $originalPrice,
                        'currency' => Session::get('currency'),
                        'imageUrl' => $imageUrl,
                    ],
                ]);
            }
        }
    }

    protected function updateCartPricesUAH()
    {
        $cart = \Cart::getContent();
        foreach ($cart as $item) {
            if ($item->attributes->currency == 'USD') {
                $this->resetCartPrices($item);
            } elseif ($item->attributes->currency == 'EUR') {
                $this->resetCartPrices($item);
            }
        }
    }

    protected function resetCartPrices($item)
    {
        $product = Product::find($item->attributes->product_id);
        $originalPrice = $product->price->pair;
        $color = $item->attributes->color;
        $size = $item->attributes->size;
        $product_quantity = $item->attributes->product_quantity;
        $imageUrl = $product->getFirstMediaUrl($product->id);;
        \Cart::update($item->id, [
            'price' => $originalPrice,
            'attributes' => [
                'product_id' => $product->id,
                'code' => $product->code,
                'color' => $color,
                'size' => $size,
                'product_quantity' => $product_quantity,
                'pair' => $originalPrice,
                'currency' => 'UAH',
                'imageUrl' => $imageUrl,
            ],
        ]);
    }
}

