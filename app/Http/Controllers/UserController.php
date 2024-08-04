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

    public function storeDailyIntake(Request $request, $userId)
    {
        // Logic to add a new daily intake entry for the user
    }

    public function updateDailyIntake(Request $request, $userId, $intakeId)
    {
        // Logic to update the daily intake information of the user
    }

    public function destroyDailyIntake($userId, $intakeId)
    {
        // Logic to delete a daily intake entry for the user
    }
}
