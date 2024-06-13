<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class NutritionalRestriction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'nutritional_profiles', 'nutritional_restriction_id', 'person_id');
    }
}
