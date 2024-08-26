<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        $ingredients = [
            ['name' => 'Chicken Breast', 'category' => 'Meat', 'kcal' => 165, 'carbohydrate' => 0, 'fat' => 3.6, 'protein' => 31, 'measurement_unit' => '100_grams'],
            ['name' => 'Broccoli', 'category' => 'Vegetable', 'kcal' => 55, 'carbohydrate' => 11, 'fat' => 0.6, 'protein' => 3.7, 'measurement_unit' => '100_grams'],
            ['name' => 'Olive Oil', 'category' => 'Oil', 'kcal' => 884, 'carbohydrate' => 0, 'fat' => 100, 'protein' => 0, 'measurement_unit' => '100_ml'],
            ['name' => 'Rice', 'category' => 'Grain', 'kcal' => 130, 'carbohydrate' => 28, 'fat' => 0.3, 'protein' => 2.7, 'measurement_unit' => '100_grams'],
            ['name' => 'Almonds', 'category' => 'Nuts', 'kcal' => 575, 'carbohydrate' => 22, 'fat' => 49, 'protein' => 21, 'measurement_unit' => '100_grams'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
