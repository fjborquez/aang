<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'name',
        'lastname',
        'date_of_birth',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function nutritionalProfile(): BelongsToMany
    {
        return $this->belongsToMany(NutritionalRestriction::class, 'nutritional_profiles', 'person_id', 'nutritional_restriction_id');
    }

    public function houses(): BelongsToMany
    {
        return $this->belongsToMany(House::class, 'persons_houses', 'person_id', 'house_id');
    }
}
