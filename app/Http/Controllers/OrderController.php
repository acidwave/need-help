<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Models\Status;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
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
        return OrderResource::collection(Order::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrderStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreRequest $request)
    {
        $validated = $request->validated();
        $order = Order::create([
            'user_id' => Auth::id(),
            'status_id' => Status::where('slug', 'new')->first()->id,
        ]);
        foreach ($validated['items'] as $value) {
            $cart_item = CartItem::find($value['item_id']);
            $order->items()->create([
                'good_id' => $cart_item->good_id,
                'cost' => $value['cost'],
                'quantity' => $value['quantity']
            ]);
            $cart_item->delete();
        }
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(order $order)
    {
        if (!Auth::user()->is_admin || Auth::id() != $order->user_id) {
            abort(403);
        }
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OrderUpdateRequest  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, order $order)
    {
        $validated = $request->validated();
        $order->update($validated['status_id']);
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
        if (!Auth::user()->is_admin || Auth::id() != $order->user_id || (Auth::id() == $order->user_id && $order->status->slug != 'new')) {
            abort(403);
        }
        $order->delete();
        return response()->json(['status' => ' success']);
    }
}
