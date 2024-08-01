<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
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
        ]);

        $query = Recipe::query();

        if (isset($validateData['meal_type'])) {
            $meal_type = $validateData['meal_type'];
            $query = $query->where('meal_type', $meal_type); //i=i+5; i=5;
        }

        if (isset($validateData['name'])) {
            $name = $validateData['name'];
            $query = $query->where('name', $name);
        }

        if (!empty($validateData['ingredient_ids'])) {
            $ingrediants_id=$validateData['ingredient_ids'];
            $query->whereHas('recipesWithIngredients', function ($q) use ($ingrediants_id) {
                return $q->whereIn('ingredients.id', $ingrediants_id);
            });
        }

        $recipes = $query->get();

        return response()->json($recipes);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:32',
            'description' => 'required|string',
            'kcal' => 'required|numeric|min:1',
            'carbohydrate' => 'required|numeric|min:1',
            'fat' => 'required|numeric|min:1',
            'protein' => 'required|numeric|min:1',
            'meal_type' => 'required|string|in:breakfast,lunch,dinner'
        ]);
        $recipe = Recipe::create($validatedData);

        return response()->json($recipe, 201);
    }

    public function show(int $id): JsonResponse
    {
        // $recipe = Recipe::findOrFail($id);// findOrfail return html
        $recipe = Recipe::where('id',$id)->with('recipesWithIngredients')->get();
        if ($recipe == null) {
            return response()->json('Recipe not found', 404); // [message=>'Recipe not found']
        }


        return response()->json($recipe, 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $recipe = Recipe::find($id);
        if ($recipe == null) {
            return response()->json('Recipe not found', 404); // [message=>'Recipe not found']
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:32',
            'description' => 'required|string',
            'kcal' => 'required|numeric',
            'carbohydrate' => 'required|numeric',
            'fat' => 'required|numeric',
            'protein' => 'required|numeric',
            'meal_type' => 'required|string|in:breakfast,lunch,dinner'
        ]);

        $recipe->update($validatedData);

        return response()->json($recipe, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)// kroz postaman poslati neeki string
    {
        $recipe = Recipe::find($id);
        if ($recipe == null) {
            return response()->json('Recipe not found', 404);
        }

        $recipe->delete();

        return response()->json(null, 204);
    }
}
