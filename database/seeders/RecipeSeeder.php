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
            Ingredient::where('name', 'Chicken Breast')->first()->id => ['quantity' => 2], // 2x100 grams
            Ingredient::where('name', 'Broccoli')->first()->id => ['quantity' => 1.5], // 1.5x100 grams
            Ingredient::where('name', 'Olive Oil')->first()->id => ['quantity' => 0.1], // 0.1x100 ml (10 ml)
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
            Ingredient::where('name', 'Rice')->first()->id => ['quantity' => 1], // 1x100 grams
            Ingredient::where('name', 'Almonds')->first()->id => ['quantity' => 0.5], // 0.5x100 grams (50 grams)
            Ingredient::where('name', 'Olive Oil')->first()->id => ['quantity' => 0.05], // 0.05x100 ml (5 ml)
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
            $quantity = $ingredient->pivot->quantity; // Adjusted quantity based on measurement unit

            // Calculate based on measurement unit
            switch ($ingredient->measurement_unit) {
                case '100_grams':
                case '100_ml':
                    $totalKcal += $ingredient->kcal * $quantity;
                    $totalCarbohydrate += $ingredient->carbohydrate * $quantity;
                    $totalFat += $ingredient->fat * $quantity;
                    $totalProtein += $ingredient->protein * $quantity;
                    break;
                case '1_piece':
                    $totalKcal += $ingredient->kcal * $quantity;
                    $totalCarbohydrate += $ingredient->carbohydrate * $quantity;
                    $totalFat += $ingredient->fat * $quantity;
                    $totalProtein += $ingredient->protein * $quantity;
                    break;
            }
        }

        $recipe->update([
            'kcal' => $totalKcal,
            'carbohydrate' => $totalCarbohydrate,
            'fat' => $totalFat,
            'protein' => $totalProtein,
        ]);
    }
}