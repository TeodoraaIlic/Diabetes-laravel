<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(): JsonResponse
    {
        $recipes = Recipe::all();

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
        ]);
        $recipe = Recipe::create($validatedData);

        return response()->json($recipe, 201);
    }

    public function show(int $id): JsonResponse
    {
        // $recipe = Recipe::findOrFail($id);// findOrfail return html
        $recipe = Recipe::find($id);
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
            'name' => 'sometimes|required|string|max:255',
            'description' => 'required|string',
            'kcal' => 'required|numeric',
            'carbohydrate' => 'required|numeric',
            'fat' => 'required|numeric',
            'protein' => 'required|numeric',
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
