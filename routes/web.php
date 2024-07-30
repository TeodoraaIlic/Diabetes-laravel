<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DailyIntakeController;
use App\Http\Controllers\RecipeController;

Route::get('/', function () {
    return view('welcome');
});


Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);
Route::get('/recipes', [RecipeController::class, 'index']);
Route::put('/recipes/{id}', [RecipeController::class, 'update']);
Route::post('/recipes', [RecipeController::class, 'store']);
// Define a GET route to get all users with their ingredient preferences
Route::get('/users', [UserController::class, 'getAllUsers']);


Route::get('/dayli-intake', [UserController::class, 'getAllUsersWithDailyIntake']);

Route::get('/dayli-intake2', [DailyIntakeController::class, 'dailyIntake']);