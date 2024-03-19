<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid",
        "name",
        "attribute_id",
    ];
    protected $casts = [
        "uuid" => "string",
        "name" => "string",
    ];
    protected $hidden = [
        "attribute_id",
    ];

    public function attribute() : object
    {
        return $this->belongsTo(Attribute::class);
    }
}
