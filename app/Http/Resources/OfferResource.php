<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            "description" => $this->description,
            "type" => $this->type,
            "discount" => $this->discount . "%",
            "limit" => $this->limit,
            "expire_date" => $this->expire_date
        ];
    }
}
