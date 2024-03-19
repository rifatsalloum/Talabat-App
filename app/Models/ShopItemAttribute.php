<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItemAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "shop_item_id",
        "value_id",
        "plus_price",
    ];
    protected $casts = [
        "uuid" => "string",
        "plus_price" => "float",
    ];
    protected $hidden = [
        "shop_item_id",
        "value_id",
    ];
    public function value() : object
    {
        return $this->belongsTo(Value::class);
    }
}
