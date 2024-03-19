<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "deliver_at",
        "address",
        "price"
    ];
    protected $casts = [
        "uuid" => "string",
        "deliver_at" => "datetime",
        "address" => "string",
        "price" => "float",
    ];
}
