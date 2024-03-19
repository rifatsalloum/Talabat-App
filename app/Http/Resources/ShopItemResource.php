<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
            "price" => $this->price . " " . $request->coin,
            "avg_rate" => $this->avg_rate,
            "trending" => $this->trending,
            "item" => ItemResource::make($this->item),
            "attributes" => ShopItemAttributesResource::collection($this->attributes),
            "category" => ShopItemCategory::make($this->itemCategory),
            "quantity" => $this->quantity,
            "offer" => OfferResource::make($this->offer),
        ];
    }
}
