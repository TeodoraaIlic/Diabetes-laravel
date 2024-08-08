<?php

use App\Http\Controllers\IngredientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DailyIntakeController;
use App\Http\Controllers\RecipeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

//rute za user intake controller
Route::get('/users/{user_id}/daily-intakes/dates',[UserController::class,'showInsertedDailyIntakeDates']);
Route::get('/users/{user_id}/daily-intakes',[UserController::class,'showDailyIntake']);
Route::post('/users/{user_id}/daily-intakes',[UserController::class,'upsertDailyIntakeEmpty']);
Route::delete('/users/{user_id}/daily-intakes/{intake_id}',[UserController::class,'destroyDailyIntake']);


//rute za ingredientController
Route::get('/ingredients', [IngredientController::class, 'index']);
Route::post('/ingredients', [IngredientController::class, 'store']);
Route::get('/ingredients/{id}', [IngredientController::class, 'show']);
Route::put('/ingredients/{id}', [IngredientController::class, 'update']);
Route::delete('/ingredients/{id}', [IngredientController::class, 'destroy']);

//rute za recipeController
Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);
Route::get('/recipes', [RecipeController::class, 'index']);
Route::put('/recipes/{id}', [RecipeController::class, 'update']);
Route::post('/recipes', [RecipeController::class, 'store']);
Route::get('/recipes/{id}', [RecipeController::class, 'show']);
// Define a GET route to get all users with their ingredient preferences



Route::get('/users', [UserController::class, 'getAllUsers']);

Route::get('/dayli-intake', [UserController::class, 'getAllUsersWithDailyIntake']);

Route::get('/dayli-intake2', [DailyIntakeController::class, 'dailyIntake']);