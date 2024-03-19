<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "name",
        "coin",
        "phone_prefix",
        "image",
    ];
    protected $casts = [
        "uuid" => "string",
        "name" => "string",
        "coin" => "string",
        "phone_prefix" => "string",
        "image" => "string",
    ];
}
