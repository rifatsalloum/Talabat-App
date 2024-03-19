<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $request["coin"] = $this->shop->country->coin;

        return [
            "uuid" => $this->uuid,
            "shop_id" => ShopResource::make($this->shop),
            "payment_id" => PaymentResource::make($this->payment),
            "delivery" => DeliveryResource::make($this->delivery),
            "ordered_items" => OrderItemResource::collection($this->orderedItems),
            "overall_price" => $this->overall_price . " " . $request->coin,
            "ordered_at" => $this->created_at->diffForHumans(),
        ];
    }
}
