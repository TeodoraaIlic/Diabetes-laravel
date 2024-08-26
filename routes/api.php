<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/reset_password_send_email', [AuthController::class, 'resetPasswordMail']);
Route::put('/reset_password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [AuthController::class, 'logout']);

    // Routes accessible by all authenticated users
    Route::middleware(['role:standard|admin|premium'])->group(function () {
        // User recipe rating routes
        Route::post('/users/recipe/{recipe_id}/rating', [UserController::class, 'storeUserRecipeRating']);

        // Ingrediants
        Route::get('/ingredients', [IngredientController::class, 'index']);
        Route::get('/ingredients/{id}', [IngredientController::class, 'show']);

        // Recipes
        Route::get('/recipes', [RecipeController::class, 'index']);
        Route::get('/recipes/{id}', [RecipeController::class, 'show']);
    });
    // Routes accessible by 'premium_user' and 'admin_user'
    Route::middleware(['role:premium|admin'])->group(function () {
        Route::get('/users/daily-intakes/dates', [UserController::class, 'showInsertedDailyIntakeDates']); ///users/{user_id}/daily-intakes/dates
        Route::get('/users/daily-intakes', [UserController::class, 'showDailyIntake']);
        Route::post('/users/daily-intakes', [UserController::class, 'upsertDailyIntakeEmpty']);
        Route::delete('/users/daily-intakes/{intake_id}', [UserController::class, 'destroyDailyIntake']);
    });

    // Routes accessible by 'admin_user' only
    Route::middleware(['role:admin'])->group(function () {
        // Ingredient routes
        Route::post('/ingredients', [IngredientController::class, 'store']);
        Route::put('/ingredients/{id}', [IngredientController::class, 'update']);
        Route::delete('/ingredients/{id}', [IngredientController::class, 'destroy']);

        // Recipe routes
        Route::post('/recipes', [RecipeController::class, 'store']);
        Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);
        Route::put('/recipes/{id}', [RecipeController::class, 'update']);
    });
});

// Authenticated Users: Access to listing ingredients and recipes, and user recipe rating.
// Premium and Admin Users: Additional access to daily intake management.
// Admin Users Only: Full CRUD operations for ingredients and recipes.


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
