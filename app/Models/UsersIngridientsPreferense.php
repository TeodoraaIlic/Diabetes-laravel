<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UsersIngridientsPreferense extends Pivot
{
    use HasFactory;

 protected $table='users_ingridients_preferenses';



}
