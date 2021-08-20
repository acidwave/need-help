<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' =>'required|exists:goods,id',
            'quantity' => 'required|integer'
        ]);
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);
        $item = $cart->items()->updateOrCreate(
            ['good_id' => $validated['item_id'], 'cart_id' => $cart->id],
            ['quantity' => $validated['quantity']
        ]
        );
        $cart->refresh();
        return new CartResource($cart);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartItem  $cart_item
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem  $cart_item)
    {
        $cart_item->delete();
        return response()->json(['status' => ' success']);
    }
}
