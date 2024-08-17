<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionalRestriction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
    ];
}
