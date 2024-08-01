<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserIngridientPreferenceController extends Controller
{
    public function getAllUsersWithPreferences(): JsonResponse
    {
        $users = User::with('ingredientPreferences.ingredient')->get();

        return response()->json($users);
    }
}
