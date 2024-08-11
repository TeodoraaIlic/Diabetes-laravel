<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(): JsonResponse
    {
                // $user=Auth::user();
        // if($user==null)
        //     return response()->json(status:401);
        $ingredient = Ingredient::all();

        return response()->json($ingredient);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:32',
            'category' => 'required|string|max:32',
            'kcal' => 'required|numeric|min:1',
            'carbohydrate' => 'required|numeric|min:1',
            'fat' => 'required|numeric|min:1',
            'protein' => 'required|numeric|min:1',
            'measurement_unit' => 'required|in:1_piece,100_grams,100_ml',
        ]);
        $ingredient = Ingredient::create($validatedData);

        return response()->json($ingredient, 201);
    }

    public function show(int $id): JsonResponse
    {

        // $recipe = Recipe::findOrFail($id);// findOrfail return html
        $ingredient = Ingredient::find($id);
        if ($ingredient == null) {
            return response()->json('Ingredient not found', 404);
        }

        return response()->json($ingredient);

    }

    public function update(Request $request, int $id): JsonResponse
    {
        $ingredient = Ingredient::find($id);
        if ($ingredient == null) {
            return response()->json('Ingredient does not exist in database', 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:32',
            'category' => 'required|string|max:32',
            'kcal' => 'required|numeric|min:1',
            'carbohydrate' => 'required|numeric|min:1',
            'fat' => 'required|numeric|min:1',
            'protein' => 'required|numeric|min:1',
            'measurement_unit' => 'required|in:1_piece,100_grams,100_ml',
        ]);

        $ingredient->update($validatedData);

        return response()->json($ingredient, 204);
    }

    public function destroy(int $id): JsonResponse
    {

        $ingredient = Ingredient::find($id);
        if ($ingredient == null) {
            return response()->json('Ingredient not found', 404);
        }

        $ingredient->delete();

        return response()->json(null, 204);
    }
}
