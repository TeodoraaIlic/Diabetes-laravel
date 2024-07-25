<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getAllUsers():JsonResponse
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getAllUsersWithDailyIntake():JsonResponse
    {
        $users = User::with('dailyIntakes')->get();
        return response()->json($users);
    }
}
