<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoodRequest;
use App\Models\Good;
use Illuminate\Support\Str;
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
     * @param  \App\Http\Requests\GoodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GoodRequest $request)
    {
        $good = Good::create($request->validated());
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
     * @param  \App\Http\Requests\GoodRequest  $request
     * @param  \App\Models\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function update(GoodRequest $request, Good $good)
    {
        $good->update($request->validated());
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
