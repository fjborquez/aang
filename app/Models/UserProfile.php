<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_of_birth',
        'is_vegetarian',
        'is_vegan',
        'is_celiac',
        'is_keto',
        'is_diabetic',
        'is_lactose',
        'is_gluten',
        'user_id'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
