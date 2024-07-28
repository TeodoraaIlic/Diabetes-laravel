<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    
    public function index()
    {
        $recipes = Recipe::all();
        return response()->json($recipes,200);
    }

   
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'kcal' => 'required|numeric',
            'carbohydrate' => 'required|numeric',
            'fat' => 'required|numeric',
            'protein' => 'required|numeric',
        ]);

        $recipe = Recipe::create($validatedData);

        return response()->json($recipe, 201);
    }

    
    public function show(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        return response()->json($recipe,200);
    }

    
    public function update(Request $request, string $id)
    {
        $recipe = Recipe::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'required|string',
            'kcal' => 'required|numeric',
            'carbohydrate' => 'required|numeric',
            'fat' => 'required|numeric',
            'protein' => 'required|numeric',
        ]);

        $recipe->update($validatedData);

        return response()->json($recipe,204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return response()->json(null, 204);
    }
}
