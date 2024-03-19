<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "shop_id",
        "item_id",
        "quantity",
        "price",
        "avg_rate",
        "trending",
        "shop_item_category_id",
        "offer_id",
    ];
    protected $casts = [
        "uuid" => "string",
        "quantity" => "integer",
        "price" => "float",
        "avg_rate" => "float",
        "trending" => "boolean",
    ];
    protected $hidden = [
        "shop_id",
        "item_id",
        "shop_item_category_id",
        "offer_id",
    ];

    public function item() : object
    {
        return $this->belongsTo(Item::class);
    }

    public function itemCategory() : object
    {
        return $this->belongsTo(ShopItemCategory::class,"shop_item_category_id");
    }

    public function attributes() : object
    {
        return $this->hasMany(ShopItemAttribute::class,"shop_item_id");
    }

    public function offer() : object
    {
        return $this->belongsTo(Offer::class);
    }
    public function attribute() : object
    {
        return $this->hasOne(ShopItemAttribute::class,"shop_item_id");
    }
}
