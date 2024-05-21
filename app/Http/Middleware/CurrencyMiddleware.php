<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
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
        if ($request->has('currency')) {
            $currency = $request->input('currency');
            Session::put('currency', $currency);

            if ($currency !== 'UAH') {
                $exchangeRates = [
                    'USD' => Session::get('currency_rate_usd', 1),
                    'EUR' => Session::get('currency_rate_eur', 1),
                ];

                $rate = $exchangeRates[$currency] ?? 1;
                $this->updateCartPrices($rate);
            } else {
                $this->resetCartPrices();
            }
        }

        return $next($request);
    }

    protected function updateCartPrices($rate)
    {
        $cart = \Cart::getContent();
        foreach ($cart as $item) {
            $originalPrice = $item->attributes->pair;
            $product = Product::find($item->attributes->product_id);
            $color = $item->attributes->color;
            $size = $item->attributes->size;
            $product_quantity = $item->attributes->product_quantity;
            $imageUrl = $product->getFirstMediaUrl($product->id);
            \Cart::update($item->id, [
                'price' => $originalPrice / $rate,
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

    protected function resetCartPrices()
    {
        $cart = \Cart::getContent();
        foreach ($cart as $item) {
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
}
//    public function handle($request, Closure $next)
//    {
//        if ($request->session()->has('currency')) {
//            $request->currency = $request->session()->get('currency');
//        } else {
//            $request->currency = 'UAH';
//            $request->session()->put('currency', $request->currency);
//        }
//
//        if (session('currency') !== 'UAH') {
//            $rate['usd'] = 'USD';
//            $rate['rate_usd'] = session()->get('currency_rate_usd');
//            $rate['eur'] = 'EUR';
//            $rate['rate_eur'] = session()->get('currency_rate_eur');
//            $this->updateCartPrices($rate);
//        } elseif (session('currency') == 'UAH') {
//            $this->resetCartPrices();
//        }
//
//        return $next($request);
//    }
//
//    protected function resetCartPrices()
//    {
//        $cart = \Cart::getContent();
//        foreach ($cart as $item) {
//            $originalPrice = $item->attributes->pair;
//            \Cart::update($item->id, [
//                'price' => $originalPrice,
//                'attributes' => [
//                    'currency' => 'UAH',
//                ],
//            ]);
//        }
//    }
//
//    protected function updateCartPrices($rate)
//    {
//        $cart = \Cart::getContent();
//        foreach ($cart as $item) {
//            $cartCurrency = $item->attributes->currency;
//            if ($cartCurrency == 'UAH' && $rate['usd']) {
//                $originalPrice = $item->attributes->pair;
//                \Cart::update($item->id, [
//                    'price' => $originalPrice / $rate['rate_usd'],
//                    'attributes' => [
//                        'currency' => $rate['usd'],
//                ],
//                ]);
//            }
//            if ($cartCurrency == 'EUR' && $rate['usd']) {
//                $originalPrice = $item->attributes->pair;
//                \Cart::update($item->id, [
//                    'price' => $originalPrice * $rate['rate_eur'],
//                    'attributes' => [
//                        'currency' => 'UAH',
//                    ],
//                ]);
//                $cartCurrency = $item->attributes->currency;
//                if ($cartCurrency == 'UAH') {
//                    $originalPrice = $item->attributes->pair;
//                    \Cart::update($item->id, [
//                        'price' => $originalPrice / $rate['rate_usd'],
//                        'attributes' => [
//                            'currency' => $rate['usd'],
//                        ],
//                    ]);
//                }
//            }
//            if ($cartCurrency == 'UAH' && $rate['eur']) {
//                $originalPrice = $item->attributes->pair;
//                \Cart::update($item->id, [
//                    'price' => $originalPrice / $rate['rate_eur'],
//                    'attributes' => [
//                        'currency' => $rate['eur'],
//                    ],
//                ]);
//            }
//            if ($cartCurrency == 'USD' && $rate['eur']) {
//                $originalPrice = $item->attributes->pair;
//                \Cart::update($item->id, [
//                    'price' => $originalPrice * $rate['rate_usd'],
//                    'attributes' => [
//                        'currency' => 'UAH',
//                    ],
//                ]);
//                $cartCurrency = $item->attributes->currency;
//                if ($cartCurrency == 'UAH') {
//                    $originalPrice = $item->attributes->pair;
//                    \Cart::update($item->id, [
//                        'price' => $originalPrice / $rate['rate_eur'],
//                        'attributes' => [
//                            'currency' => $rate['eur'],
//                        ],
//                    ]);
//                }
//            }
//        }
//    }
//}

