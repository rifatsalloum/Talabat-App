<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "user_id",
        "shop_id",
        "payment_id",
        "delivery_id",
        "overall_price",
    ];
    protected $casts = [
        "uuid" => "string",
        "overall_price" => "float",
    ];
    protected $hidden = [
        "user_id",
        "shop_id",
        "payment_id",
        "delivery_id",
    ];

    public function shop() : object
    {
        return $this->belongsTo(Shop::class);
    }

    public function payment() : object
    {
        return $this->belongsTo(Payment::class);
    }

    public function delivery() : object
    {
        return $this->belongsTo(Delivery::class);
    }

    public function orderedItems() : object
    {
        return $this->hasMany(OrderItem::class);
    }
}
