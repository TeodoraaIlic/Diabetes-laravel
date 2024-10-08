<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'kcal',
        'carbohydrate',
        'fat',
        'protein',
        'measurement_unit',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(UserIngridientPreferense::class);

    }

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->withPivot('quantity');
    }
}
