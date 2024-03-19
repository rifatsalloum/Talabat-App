<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRateRequest;
use App\Http\Resources\MessageResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Rate;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RateController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRateRequest $storeRateRequest)
    {
        try {

            $shop = Shop::where("uuid",$storeRateRequest->shop_id)->firstOrFail();
            $user = auth("sanctum")->user();

            $rate = Rate::where("user_id",$user->id)->where("shop_id",$shop->id)->first();
            if($rate)
                return $this->update($storeRateRequest,$rate);

            Rate::create([

                "uuid" => Str::uuid(),
                "shop_id" => $shop->id,
                "user_id" => $user->id,
                "rate" => $storeRateRequest->rate,
                "comment" => $storeRateRequest->comment,

            ]);

            return $this->apiResponse(

                MessageResource::make("rating done")

            );

        }catch (\Exception $e){

            return $this->requiredField($e->getMessage());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show(Rate $rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRateRequest $storeRateRequest, Rate $rate)
    {
        try {

            $rate->rate = $storeRateRequest->rate;
            $rate->comment = $storeRateRequest->comment;

            $rate->save();

            return $this->apiResponse(

                MessageResource::make("updating done")

            );

        }catch (\Exception $e){

            return $this->requiredField($e->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate)
    {
        //
    }
}
