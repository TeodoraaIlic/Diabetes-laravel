<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DailyIntakeController;
Route::get('/', function () {
    return view('welcome');
});





// Define a GET route to get all users with their ingredient preferences
Route::get('/users', [UserController::class, 'getAllUsers']);


Route::get('/dayli-intake', [UserController::class, 'getAllUsersWithDailyIntake']);

Route::get('/dayli-intake2', [DailyIntakeController::class, 'dailyIntake']);