<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRecipeRating extends Pivot
{
    use HasFactory;

    protected $table = 'user_recipe_ratings';
    protected $fillable = [
        'user_id',
        'recipe_id',
        'rating'
    ];
}
