<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }
        return CartResource::collection(Cart::paginate());
    }

    /**
      * Display the specified resource.
      *
      * @param  \App\Models\Cart  $cart
      * @return \Illuminate\Http\Response
      */
    public function show(Cart $cart)
    {
        if (!Auth::user()->is_admin || Auth::id() != $cart->user_id) {
            abort(403);
        }
        return new CartResource($cart);
    }
}
