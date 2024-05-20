<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
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
        $cartItems = \Cart::getContent()->sortBy('id');

        // Counting Cart's additional parameters
        $cartItems->totalPrice = $cartItems->totalDiscountPrice = 0;
        $cartItems->map(function ($item) use($cartItems) {
            $cartItems->totalPrice += $item->quantity * $item->price;
            $cartItems->totalDiscountPrice +=
                $item->attributes->pair
                    ? $item->quantity * $item->attributes->pair
                    : $item->quantity * $item->price;
        });
        $cartItems->totalDiscount = $cartItems->totalPrice - $cartItems->totalDiscountPrice;

        return view('site.cart.cart', compact('cartItems'));
    }

    /**
     * Add new item to Cart.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function addToCart(Request $request): RedirectResponse
    {
        $product = Product::find($request->post('product_id'));
        $productVariant = ProductVariant::where('product_id', $request->post('product_id'))->where('color_id', $request->post('color_id'))->where('size_id', $request->post('size_id'))->first();

        \Cart::add([
            'id' => $product->id.'_p',
            'name' => $product->title,
            'price' => $product->price->pair,
            'quantity' => 1,
            'attributes' => [
                'product_id' => $product->id,
                'article' => $product->code,
                'color' => $productVariant->color->title ,
                'size' => $productVariant->size->title ,
                'product_quantity' => $productVariant->quantity,
                'pair' => $product->price->pair,
                'imageUrl' => $product->getFirstMediaUrl($product->id),
            ],
        ]);

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
