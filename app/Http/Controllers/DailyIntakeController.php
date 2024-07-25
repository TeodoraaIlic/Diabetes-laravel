<?php

namespace App\Http\Controllers;

use App\Models\DailyIntake;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DailyIntakeController extends Controller
{
   public function dailyIntake():JsonResponse
   {
     $day=DailyIntake:: with('user');
     $resault=$day->get();
     return response()->json($resault);
   }
}
