<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "shop_id",
        "shop_item_id",
        "shop_item_attribute_id",
        "number",
        "price",
        "notes",
    ];
    protected $casts = [
        "uuid" => "string",
        "number" => "integer",
        "notes" => "string",
        "price" => "float",
    ];
    protected $hidden = [
        "shop_id",
        "shop_item_id",
        "shop_item_attribute_id",
    ];
}
