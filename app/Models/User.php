<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'first_name',
        'last_name',
        'weight',
        'height',
        'birthday_date',
        'activity_level',
        'type',

        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function dailyIntakes(): HasMany
    {
        return $this->hasMany(DailyIntake::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)->using(UserIngridientPreferense::class);
    }

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->using(UserRecipeRating::class);
    }
}
