<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $request["coin"] = ($request->coin)? $request->coin : $this->country->coin;

        return [
            "uuid" => $this->uuid,
            "name" => $this->name,
            "address" => $this->address,
            "phone" => $this->phone,
            "email" => $this->email,
            "image" => $this->image,
            "delivery_price" => $this->delivery_price . " " . $request->coin,
            "delivery_time" => $this->delivery_time . " mins",
            "delivery_discount" => $this->delivery_discount . "%",
            "cuisine" => CuisineResource::make($this->cuisine),
            "avg_rate" => $this->avg_rate,
            "offer" => OfferResource::make($this->offer),
            "menu" => ShopItemResource::collection($this->shopItems->sortByDesc("avg_rate")),
        ];
    }
}
