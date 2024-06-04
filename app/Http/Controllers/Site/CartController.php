<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Darryldecode\Cart\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of Cart items.
     *
     * @return View
     */
    public function cartList(): View
    {
        $this->addGiftsToCartIfNeeded();
        $cartItems = \Cart::getContent()->sortBy('id');

        // Counting Cart's additional parameters
        $cartItems->totalPrice = $cartItems->totalDiscountPrice = 0;
        $cartItems->map(function ($item) use($cartItems) {
            $cartItems->totalPrice += $item->quantity * $item->price;
            $cartItems->totalDiscountPrice += $item->quantity * $item->price;
        });
        $cartItems->totalDiscount = $cartItems->totalPrice - $cartItems->totalDiscountPrice;

        // Check if total price exceeds 2500 and apply discount
        $discount = 0;
        if(session()->get('currency') == 'USD') {
            $currencyRateUsd = session()->get('currency_rate_usd');

            if ($cartItems->totalPrice > ( 2500 / $currencyRateUsd ) && $cartItems->totalPrice <= ( 5000 / $currencyRateUsd )) {
                // Assuming a 10% discount for this example
                $discount = $cartItems->totalPrice * 0.10;
                $cartItems->totalDiscountPrice -= $discount;
                $cartItems->totalDiscount += $discount;
            }

            // Check if total price exceeds 1000 and apply free shipping
            $freeShipping = false;
            if ($cartItems->totalPrice > ( 1000 / $currencyRateUsd ) && $cartItems->totalPrice < ( 2500 / $currencyRateUsd )) {
                $freeShipping = true;
            }

            // Check if total price is below minimum threshold
            $minimumAmount = ( 500 / $currencyRateUsd );
            $belowMinimumAmount = $cartItems->totalPrice < $minimumAmount;
        } elseif(session()->get('currency') == 'EUR') {
            $currencyRateEUR = session()->get('currency_rate_eur');

            if ($cartItems->totalPrice > ( 2500 / $currencyRateEUR ) && $cartItems->totalPrice <= ( 5000 / $currencyRateEUR )) {
                // Assuming a 10% discount for this example
                $discount = $cartItems->totalPrice * 0.10;
                $cartItems->totalDiscountPrice -= $discount;
                $cartItems->totalDiscount += $discount;
            }

            // Check if total price exceeds 1000 and apply free shipping
            $freeShipping = false;
            if ($cartItems->totalPrice > ( 1000 / $currencyRateEUR ) && $cartItems->totalPrice < ( 2500 / $currencyRateEUR )) {
                $freeShipping = true;
            }

            // Check if total price is below minimum threshold
            $minimumAmount = ( 500 / $currencyRateEUR );
            $belowMinimumAmount = $cartItems->totalPrice < $minimumAmount;
        } else {
            if ($cartItems->totalPrice > 2500 && $cartItems->totalPrice <= 5000) {
                // Assuming a 10% discount for this example
                $discount = $cartItems->totalPrice * 0.10;
                $cartItems->totalDiscountPrice -= $discount;
                $cartItems->totalDiscount += $discount;
            }

            // Check if total price exceeds 1000 and apply free shipping
            $freeShipping = false;
            if ($cartItems->totalPrice > 1000 && $cartItems->totalPrice < 2500) {
                $freeShipping = true;
            }

            // Check if total price is below minimum threshold
            $minimumAmount = 500;
            $belowMinimumAmount = $cartItems->totalPrice < $minimumAmount;
        }

        return view('site.cart.cart', compact('cartItems', 'discount', 'freeShipping', 'belowMinimumAmount', 'minimumAmount'));
    }

    public function addGiftsToCartIfNeeded()
    {
        $totalPrice = \Cart::getTotal();

        $giftItemFirst = \Cart::get('gift_1');
        $giftItemSecond = \Cart::get('gift_2');

        if (session()->get('currency') == 'USD') {
            $currency_rate_usd = session()->get('currency_rate_usd');
            if ($totalPrice > ( 7000 / $currency_rate_usd )) {
                if (!$giftItemSecond) {
                    \Cart::remove('gift_1');

                    \Cart::add([
                        'id' => 'gift_2',
                        'name' => 'Подарунковий товар 2',
                        'price' => 0,
                        'quantity' => 1,
                        'attributes' => [
                            'is_gift' => true,
                        ],
                    ]);
                } elseif ($totalPrice <= ( 7000 / $currency_rate_usd )) {
                    \Cart::remove('gift_2');
                }
            } else {
                if ($totalPrice > ( 5000 / $currency_rate_usd ) && !$giftItemFirst) {
                    \Cart::remove('gift_2');

                    \Cart::add([
                        'id' => 'gift_1',
                        'name' => 'Подарунковий товар 1',
                        'price' => 0,
                        'quantity' => 1,
                        'attributes' => [
                            'is_gift' => true,
                        ],
                    ]);
                } elseif ($totalPrice <= ( 5000 / $currency_rate_usd )) {
                    \Cart::remove('gift_1');
                }
            }
        } elseif (session()->get('currency') == 'EUR') {
            $currency_rate_eur = session()->get('currency_rate_eur');
            if ($totalPrice > ( 7000 / $currency_rate_eur )) {
                if (!$giftItemSecond) {
                    \Cart::remove('gift_1');

                    \Cart::add([
                        'id' => 'gift_2',
                        'name' => 'Подарунковий товар 2',
                        'price' => 0,
                        'quantity' => 1,
                        'attributes' => [
                            'is_gift' => true,
                        ],
                    ]);
                } elseif ($totalPrice <= ( 7000 / $currency_rate_eur )) {
                    \Cart::remove('gift_2');
                }
            } else {
                if ($totalPrice > ( 5000 / $currency_rate_eur ) && !$giftItemFirst) {
                    \Cart::remove('gift_2');

                    \Cart::add([
                        'id' => 'gift_1',
                        'name' => 'Подарунковий товар 1',
                        'price' => 0,
                        'quantity' => 1,
                        'attributes' => [
                            'is_gift' => true,
                        ],
                    ]);
                } elseif ($totalPrice <= ( 5000 / $currency_rate_eur )) {
                    \Cart::remove('gift_1');
                }
            }
        } elseif (session()->get('currency') == 'UAH') {
            if ($totalPrice > 7000) {
                if (!$giftItemSecond) {
                    \Cart::remove('gift_1');

                    \Cart::add([
                        'id' => 'gift_2',
                        'name' => 'Подарунковий товар 2',
                        'price' => 0,
                        'quantity' => 1,
                        'attributes' => [
                            'is_gift' => true,
                        ],
                    ]);
                } elseif ($totalPrice <= 7000) {
                    \Cart::remove('gift_2');
                }
            } else {
                if ($totalPrice > 5000 && !$giftItemFirst) {
                    \Cart::remove('gift_2');

                    \Cart::add([
                        'id' => 'gift_1',
                        'name' => 'Подарунковий товар 1',
                        'price' => 0,
                        'quantity' => 1,
                        'attributes' => [
                            'is_gift' => true,
                        ],
                    ]);
                } elseif ($totalPrice <= 5000) {
                    \Cart::remove('gift_1');
                }
            }
        }
    }

    /**
     * @param CartRequest $request
     * @return RedirectResponse
     */
    public function addToCart(CartRequest $request): RedirectResponse
    {
        $product = Product::find($request->post('product_id'));
        $productVariant = ProductVariant::where('product_id', $request->post('product_id'))->where('color_id', $request->post('color_id_popup'))->where('size_id', $request->post('size_id_popup'))->first();

        if(session()->get('currency') == 'USD') {
            $currency_rate_usd = session()->get('currency_rate_usd');
            $currency = session()->get('currency');
            \Cart::add([
                'id' => $productVariant->id.'_p',
                'name' => $product->title,
                'price' => ($product->price->pair / $currency_rate_usd),
                'quantity' => 1,
                'attributes' => [
                    'product_id' => $product->id,
                    'code' => $product->code,
                    'color' => $productVariant->color->title ,
                    'size' => $productVariant->size->title ,
                    'product_quantity' => $productVariant->quantity,
                    'pair' => $product->price->pair / $currency_rate_usd,
                    'currency' => $currency,
                    'imageUrl' => $product->getFirstMediaUrl($product->id),
                ],
            ]);
        } elseif (session()->get('currency') == 'EUR') {
            $currency_rate_eur = session()->get('currency_rate_eur');
            $currency = session()->get('currency');
            \Cart::add([
                'id' => $productVariant->id.'_p',
                'name' => $product->title,
                'price' => ($product->price->pair / $currency_rate_eur),
                'quantity' => 1,
                'attributes' => [
                    'product_id' => $product->id,
                    'code' => $product->code,
                    'color' => $productVariant->color->title ,
                    'size' => $productVariant->size->title ,
                    'product_quantity' => $productVariant->quantity,
                    'pair' => $product->price->pair / $currency_rate_eur,
                    'currency' => $currency,
                    'imageUrl' => $product->getFirstMediaUrl($product->id),
                ],
            ]);
        } elseif (session()->get('currency') == 'UAH') {
            $currency = session()->get('currency');
            \Cart::add([
                'id' => $productVariant->id.'_p',
                'name' => $product->title,
                'price' => $product->price->pair,
                'quantity' => 1,
                'attributes' => [
                    'product_id' => $product->id,
                    'code' => $product->code,
                    'color' => $productVariant->color->title ,
                    'size' => $productVariant->size->title ,
                    'product_quantity' => $productVariant->quantity,
                    'pair' => $product->price->pair,
                    'currency' => $currency,
                    'imageUrl' => $product->getFirstMediaUrl($product->id),
                ],
            ]);
        }

        return to_route('cart');
    }

    /**
     * Update item in Cart.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => 'required|string|max:12',
            'quantity' => 'required|integer|max:1024',
        ]);
        // Deduct quantity
        if ($request->has('quantityDed') && ($validated['quantity'] > 1)) {
            \Cart::update(
                $validated['id'],
                [
                    'quantity' => [
                        'relative' => false,
                        'value' => $validated['quantity'] - 1,
                    ],
                ]
            );
        }
        // Add quantity
        if ($request->has('quantityAdd')) {
            \Cart::update(
                $validated['id'],
                [
                    'quantity' => [
                        'relative' => false,
                        'value' => $validated['quantity'] + 1,
                    ],
                ]
            );
        }

        return back()->with('cart', 'cart_updated');
    }

    /**
     * Remove item from Cart.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeCart(Request $request): RedirectResponse
    {
        $idSize = $request->validate(['id' => 'required|string|max:12'])['id'];
        \Cart::remove($idSize);

        return back()->with('cart', 'cart_deleted');
    }
}
