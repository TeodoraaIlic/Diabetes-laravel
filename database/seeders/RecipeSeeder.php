<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Ingredient;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        // Existing recipe
        $recipe1 = Recipe::create([
            'name' => 'Grilled Chicken with Broccoli',
            'description' => 'A healthy and delicious grilled chicken breast served with steamed broccoli.',
            'kcal' => 0, // Placeholder, will be calculated
            'carbohydrate' => 0, // Placeholder, will be calculated
            'fat' => 0, // Placeholder, will be calculated
            'protein' => 0, // Placeholder, will be calculated
            'meal_type' => 'lunch',
        ]);

        $recipe1->ingredientsForRecipe()->attach([
            Ingredient::where('name', 'Chicken Breast')->first()->id => ['quantity' => 200],
            Ingredient::where('name', 'Broccoli')->first()->id => ['quantity' => 150],
            Ingredient::where('name', 'Olive Oil')->first()->id => ['quantity' => 10],
        ]);

        $this->updateRecipeNutrition($recipe1);

        // New recipe
        $recipe2 = Recipe::create([
            'name' => 'Almond Rice Pudding',
            'description' => 'A creamy and delicious almond rice pudding perfect for dessert or breakfast.',
            'kcal' => 0, // Placeholder, will be calculated
            'carbohydrate' => 0, // Placeholder, will be calculated
            'fat' => 0, // Placeholder, will be calculated
            'protein' => 0, // Placeholder, will be calculated
            'meal_type' => 'breakfast',
        ]);

        $recipe2->ingredientsForRecipe()->attach([
            Ingredient::where('name', 'Rice')->first()->id => ['quantity' => 100],
            Ingredient::where('name', 'Almonds')->first()->id => ['quantity' => 50],
            Ingredient::where('name', 'Olive Oil')->first()->id => ['quantity' => 5],
        ]);

        $this->updateRecipeNutrition($recipe2);
    }

    private function updateRecipeNutrition(Recipe $recipe)
    {
        $totalKcal = 0;
        $totalCarbohydrate = 0;
        $totalFat = 0;
        $totalProtein = 0;

        foreach ($recipe->ingredientsForRecipe as $ingredient) {
            $totalKcal += $ingredient->kcal * $ingredient->pivot->quantity / 100;
            $totalCarbohydrate += $ingredient->carbohydrate * $ingredient->pivot->quantity / 100;
            $totalFat += $ingredient->fat * $ingredient->pivot->quantity / 100;
            $totalProtein += $ingredient->protein * $ingredient->pivot->quantity / 100;
        }

        $recipe->update([
            'kcal' => $totalKcal,
            'carbohydrate' => $totalCarbohydrate,
            'fat' => $totalFat,
            'protein' => $totalProtein,
        ]);
    }
}