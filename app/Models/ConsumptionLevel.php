<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'name',
        'description',
    ];

    protected $casts = [
        'value' => 'integer',
        'name' => 'string',
        'description' => 'string',
    ];
}
