<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "order_id",
        "shop_item_id",
        "shop_item_attribute_id",
        "price",
        "number",
        "notes",
    ];
    protected $casts = [
        "uuid" => "string",
        "price" => "float",
        "number" => "integer",
        "notes" => "string",
    ];
    protected $hidden = [
        "order_id",
        "shop_item_id",
        "shop_item_attribute_id",
    ];

    public function shopItem() : object
    {
        return $this->belongsTo(ShopItem::class,"shop_item_id");
    }
    public function itemAttribute() : object
    {
        return $this->belongsTo(ShopItemAttribute::class,"shop_item_attribute_id");
    }
}
