<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Thiagoprz\CompositeKey\HasCompositeKey;

class NutritionalProfile extends Model
{
    use HasCompositeKey;
    use HasFactory;

    protected $primaryKey = ['person_id', 'product_category_id'];

    protected $fillable = ['person_id', 'product_category_id', 'product_category_name', 'consumption_level_id'];

    public $incrementing = false;

    public function getKeyName()
    {
        return ['person_id', 'product_category_id'];
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function consumptionLevel(): HasOne
    {
        return $this->hasOne(ConsumptionLevel::class, 'id', 'consumption_level_id');
    }
}
