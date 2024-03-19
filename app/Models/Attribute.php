<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "name",
        "is_required"
    ];
    protected $casts = [
        "uuid" => "string",
        "name" => "string",
        "is_required" => "boolean",
    ];
}
