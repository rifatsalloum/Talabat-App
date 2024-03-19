<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            "item" => ShopItemResource::make($this->shopItem),
            "attribute" => ShopItemAttributesResource::make($this->itemAttribute),
            "price" => $this->price . " " . $request->coin,
            "number" => $this->number,
            "notes" => $this->notes,
        ];
    }
}
