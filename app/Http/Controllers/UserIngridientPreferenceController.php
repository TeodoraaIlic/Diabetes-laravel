<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class UserIngridientPreferenceController extends Controller
{
    public function getAllUsersWithPreferences():JsonResponse
    {
        $users = User::with('ingredientPreferences.ingredient')->get();
        return response()->json($users);
    }
}
