<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function getAllUsers(): JsonResponse
    {
        $users = User::all();

        return response()->json($users);
    }

    public function getAllUsersWithDailyIntake(): JsonResponse
    {
        $users = User::with('dailyIntakes')->get();

        return response()->json($users);
    }
}
