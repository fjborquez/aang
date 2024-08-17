<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class NutritionalProfile extends Model
{
    use HasFactory;
    use HasCompositeKey;

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
}
