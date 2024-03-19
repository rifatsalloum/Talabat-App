<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "name",
        "description",
        "image",
        "item_category_id",
    ];
    protected $casts = [
        "uuid" => "string",
        "name" => "string",
        "description" => "string",
        "image" => "string",
    ];
    protected $hidden = [
        "item_category_id",
    ];

    public function category() : object
    {
        return $this->belongsTo(ItemCategory::class,"item_category_id");
    }
}
