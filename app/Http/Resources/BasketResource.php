<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BasketResource extends JsonResource
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
            "item" => ShopItemResource::make($request->shop_item_ids[$this->shop_item_id]),
            "attribute" => ($this->attribute_id)? ValueResource::make($request->attribute_ids[$this->attribute_id]->value) : null,
            "price" => $this->price . " " . $request->coin,
            "number" => $this->number,
            "notes" => $this->notes,
        ];
    }
}
