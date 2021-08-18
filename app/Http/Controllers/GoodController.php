<?php

namespace App\Http\Controllers;

use App\Models\Good;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\GoodResource;

class GoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GoodResource::collection(Good::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|string',
            'cost' => 'required|numeric',
        ]);
        $good = new Good();
        $good->title = $validated['title'];
        $good->slug = Str::slug($validated['title']);
        $good->cost = $validated['cost'];
        $good->save();
        return new GoodResource($good);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function show(Good $good)
    {
        return new GoodResource($good);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Good $good)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|string',
            'cost' => 'required|numeric',
        ]);
        $good->title = $validated['title'];
        $good->slug = Str::slug($validated['title']);
        $good->cost = $validated['cost'];
        $good->save();
        return new GoodResource($good);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function destroy(Good $good)
    {
        $good->delete();
        return response()->json(['status' => ' success']);
    }
}
