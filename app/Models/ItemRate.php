<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRate extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "shop_item_id",
        "user_id",
        "rate",
        "comment"
    ];
    protected $casts = [
        "uuid" => "string",
        "rate" => "integer",
        "comment" => "string",
    ];
    protected $hidden = [
        "shop_item_id",
        "user_id",
    ];
}
