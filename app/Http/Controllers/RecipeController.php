<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validateData = $request->validate([
            'meal_type' => 'nullable|string|in:breakfast,lunch,dinner',
            'name' => 'nullable|string|max:32',
            'ingredient_ids' => 'nullable|array',
            'ingredient_ids.*' => 'integer|exists:ingredients,id',
            'page' => 'required|integer|min:1',
        ]);

        $query = Recipe::query();

        if (isset($validateData['meal_type'])) {
            $query->where('meal_type', $validateData['meal_type']);
        }

        if (isset($validateData['name'])) {
            $query->where('name', $validateData['name']);
        }

        if (!empty($validateData['ingredient_ids'])) {
            $ingredientIds = $validateData['ingredient_ids'];
            $query->whereHas('ingredientsForRecipe', function ($q) use ($ingredientIds) {
                $q->whereIn('ingredients.id', $ingredientIds);
            });
        }

        $recipes = $query->paginate(perPage: 12, page: $validateData['page']);

        return response()->json($recipes);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:32',
            'description' => 'required|string',
            'meal_type' => 'required|string|in:breakfast,lunch,dinner',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|integer|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:1',
        ]);

        // Calculate total nutrition
        $nutrition = $this->calculateNutrition($validatedData['ingredients']);

        // Create the recipe
        $recipe = Recipe::create(array_merge($validatedData, $nutrition));

        // Attach ingredients with quantities
        foreach ($validatedData['ingredients'] as $ingredient) {
            $recipe->ingredientsForRecipe()->attach($ingredient['id'], ['quantity' => $ingredient['quantity']]);
        }

        return response()->json($recipe, 201);
    }

    public function show(int $id): JsonResponse
    {
        $recipe = Recipe::with('ingredientsForRecipe:id,name,kcal,carbohydrate,fat,protein')
            ->find($id);

        if (!$recipe) {
            return response()->json('Recipe not found', 404);
        }

        return response()->json($recipe, 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $recipe = Recipe::find($id);
        if (!$recipe) {
            return response()->json('Recipe not found', 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:32',
            'description' => 'required|string',
            'meal_type' => 'required|string|in:breakfast,lunch,dinner',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|integer|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:1',
        ]);

        // Calculate total nutrition
        $nutrition = $this->calculateNutrition($validatedData['ingredients']);

        // Update the recipe
        $recipe->update(array_merge($validatedData, $nutrition));

        // Sync ingredients with quantities
        $ingredients = [];
        foreach ($validatedData['ingredients'] as $ingredient) {
            $ingredients[$ingredient['id']] = ['quantity' => $ingredient['quantity']];
        }
        $recipe->ingredientsForRecipe()->sync($ingredients);

        return response()->json($recipe, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $recipe = Recipe::find($id);
        if (!$recipe) {
            return response()->json('Recipe not found', 404);
        }

        // Automatically detaches all related ingredients
        $recipe->delete();

        return response()->json(null, 204);
    }

    private function calculateNutrition(array $ingredients): array
    {
        $totalKcal = 0;
        $totalCarbohydrate = 0;
        $totalFat = 0;
        $totalProtein = 0;

        foreach ($ingredients as $ingredient) {
            $ing = Ingredient::find($ingredient['id']);
            if ($ing) {
                $quantity = $ingredient['quantity']; // Quantity in the unit specified by the ingredient

                switch ($ing->measurement_unit) {
                    case '100_grams':
                    case '100_ml':
                        $totalKcal += $ing->kcal * $quantity;
                        $totalCarbohydrate += $ing->carbohydrate * $quantity;
                        $totalFat += $ing->fat * $quantity;
                        $totalProtein += $ing->protein * $quantity;
                        break;
                    case '1_piece':
                        $totalKcal += $ing->kcal * $quantity;
                        $totalCarbohydrate += $ing->carbohydrate * $quantity;
                        $totalFat += $ing->fat * $quantity;
                        $totalProtein += $ing->protein * $quantity;
                        break;
                }
            }
        }

        return [
            'kcal' => $totalKcal,
            'carbohydrate' => $totalCarbohydrate,
            'fat' => $totalFat,
            'protein' => $totalProtein,
        ];
    }
}
