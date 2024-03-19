<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItemCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "name",
        "item_category_id",
    ];
    protected $casts = [
        "uuid" => "string",
        "name" => "string",
    ];
    protected $hidden = [
        "item_category_id",
    ];
}
