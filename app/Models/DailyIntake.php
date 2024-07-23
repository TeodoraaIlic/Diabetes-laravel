<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyIntake extends Model
{
    

    use HasFactory;

 protected $fillable=[
    'breakfast',
    'breakfast_portion',
    'lunch',
    'lunch_portion',
    'dinner',
    'dinner_portion'
];

public function user():BelongsTo
{
    return $this->belongsTo(User::class);
}

}
