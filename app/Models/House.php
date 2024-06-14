<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'city_id',
        'is_active',
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(House::class, 'persons_houses', 'house_id', 'person_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
