<?php

namespace App\Http\Controllers;

use App\Models\DailyIntake;
use App\Models\User;
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
}
