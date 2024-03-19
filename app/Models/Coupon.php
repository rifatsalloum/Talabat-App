<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "code",
        "discount",
    ];
    protected $casts = [
        "uuid" => "string",
        "code" => "string",
        "discount" => "integer",
    ];
}
