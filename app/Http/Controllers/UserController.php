<?php

namespace App\Http\Controllers;

use App\Models\DailyIntake;
use App\Models\Recipe;
use App\Models\User;
use App\Models\UserRecipeRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // spisak svih datuma za koje je user uneo daily intake
    public function showInsertedDailyIntakeDates(int $userId): JsonResponse
    {
        // $dailyIntakes = DailyIntake::select(['date'])
        //                     ->where('user_id', $userId)
        //                     ->distinct()
        //                     ->get();

        // return response()->json($dailyIntakes);

        $dates = DailyIntake::where('user_id', $userId)
            ->distinct()
            ->pluck('date');

        return response()->json(['dates' => $dates]);
    }

    public function showDailyIntake(int $userId, Request $request): JsonResponse
    {
        $validateData = $request->validate([
            'date' => 'required|date',
        ]);

        $dailyIntake = DailyIntake::where('user_id', $userId)
            ->where('date', $validateData['date'])
            ->first();

        return response()->json($dailyIntake);
    }

    /**
        *upsert
     */
    public function upsertDailyIntakeEmpty(Request $request,int $userId)
    {
        $validateData = $request->validate([
            'date' => 'required|date',
            'breakfast'=>'nullable|integer|exists:recipes,id',
            'breakfast_portion'=>'nullable|numeric',
            'lunch'=>'nullable|integer|exists:recipes,id',
            'lunch_portion'=>'nullable|numeric',
            'dinner'=>'nullable|integer|exists:recipes,id',
            'dinner_portion'=>'nullable|numeric',
        ]);

        $dailyIntake=DailyIntake::where('date',$validateData['date'])->where('user_id',$userId)->first();
        if($dailyIntake==null){
            $validateData['user_id']=$userId;
        
            $dailyIntake = DailyIntake::create($validateData);  
            return response()->json($dailyIntake,201);         
        }

        $dailyIntake->update($validateData);
        return response()->json($dailyIntake, 200);
    }

    public function destroyDailyIntake(int $userId,int $intakeId)
    {
        $dailyIntake=DailyIntake::where('user_id',$userId)->where('id',$intakeId)->first();
        if($dailyIntake==null){
           return response()->json('Daily intake not found',404);
        }
        $dailyIntake->delete();
        return response()->json(null, 204);
    }

    public function storeUserRecipeRating(Request $request,int $userId,int $recipeId)
    {
        $validateData = $request->validate([
            'rating'=>'required|integer|min:1|max:5'     
        ]);

        $userRecipeRating=UserRecipeRating::where('user_id',$userId)->where('recipe_id',$recipeId)->first();
        if($userRecipeRating!=null){
            return response()->json('User already rated recipe!',422);
        }

        $validateData['user_id']=$userId;
        $validateData['recipe_id']=$recipeId;
        $userRecipeRating=UserRecipeRating::create($validateData);

        
        $averageRating = UserRecipeRating::where('recipe_id', $recipeId)->avg('rating');

        Recipe::where('id', $recipeId)->update(['rating' => $averageRating]);
    
        return response()->json($userRecipeRating, 201);
    }
    
}
