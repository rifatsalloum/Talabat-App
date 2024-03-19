<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRateRequest;
use App\Http\Resources\MessageResource;
use App\Http\Traits\GeneralTrait;
use App\Models\ItemRate;
use App\Models\ShopItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemRateController extends Controller
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

            $shop_item = ShopItem::where("uuid",$storeRateRequest->shop_item_id)->firstOrFail();
            $user = auth("sanctum")->user();

            $itemRate = ItemRate::where("user_id",$user->id)->where("shop_item_id",$shop_item->id)->first();
            if($itemRate)
                return $this->update($storeRateRequest,$itemRate);

            ItemRate::create([

                "uuid" => Str::uuid(),
                "shop_item_id" => $shop_item->id,
                "user_id" => $user->id,
                "rate" => $storeRateRequest->rate,
                "comment" => $storeRateRequest->comment,

            ]);

            return $this->apiResponse(

                MessageResource::make("rate added")

            );
        }catch (\Exception $e){

            return $this->requiredField($e->getMessage());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemRate  $itemRate
     * @return \Illuminate\Http\Response
     */
    public function show(ItemRate $itemRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemRate  $itemRate
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRateRequest $storeRateRequest, ItemRate $itemRate)
    {
        try {

            $itemRate->rate = $storeRateRequest->rate;
            $itemRate->comment = $storeRateRequest->comment;

            $itemRate->save();

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
     * @param  \App\Models\ItemRate  $itemRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemRate $itemRate)
    {
        //
    }
}
