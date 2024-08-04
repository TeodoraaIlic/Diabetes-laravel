<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'description', ///ingrediants fali
        'kcal',
        'carbohydrate',
        'fat',
        'protein',
        'meal_type',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(UserRecipeRating::class);
    }

    public function ingredientsForRecipe(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)
            ->withPivot('quantity');
    }// fja vraca listu ingredianta za neki proizvod
}
