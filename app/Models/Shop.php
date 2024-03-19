<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "name",
        "address",
        "phone",
        "email",
        "image",
        "delivery_price",
        "delivery_time",
        "delivery_discount",
        "avg_rate",
        "basket_price",
        "country_id",
        "cuisine_id",
        "offer_id",
    ];
    protected $casts = [
        "uuid" => "string",
        "name" => "string",
        "address" => "string",
        "phone" => "string",
        "email" => "string",
        "image" => "string",
        "delivery_price" => "float",
        "delivery_time" => "integer",
        "delivery_discount" => "integer",
        "avg_rate" => "float",
    ];
    protected $hidden = [
        "country_id",
        "cuisine_id",
        "offer_id",
        "basket_price",
    ];

    public function offer() : object
    {
        return $this->belongsTo(Offer::class);
    }
    public function items() : object
    {
        return $this->belongsToMany(Item::class,"shop_items");
    }
    public function cuisine() : object
    {
        return $this->belongsTo(Cuisine::class);
    }
    public function shopItems() : object
    {
        return $this->hasMany(ShopItem::class);
    }

    public function baskets() : object
    {
        return $this->hasMany(Basket::class);
    }

    public function country() : object
    {
        return $this->belongsTo(Country::class);
    }
}
