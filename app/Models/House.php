<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class House extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'description',
        'city_id',
        'is_active',
    ];

    protected $casts = [
        'description' => 'string',
        'city_id' => 'integer',
        'is_active' => 'boolean',
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'persons_houses', 'house_id', 'person_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getRequiredAttributes(): array
    {
        return ['description', 'city_id'];
    }
}
