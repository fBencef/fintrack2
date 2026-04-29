<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $primaryKey = 'user_id';
    //public $incrementing = true;
    //protected $keyType = 'int';

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'given_name',
        'email',
        'password',
        'dashboard_preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'dashboard_preferences' => '{"monthly_spending":true,"category_chart":true,"recent_transactions":true}',
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
            'dashboard_preferences' => 'array',
        ];
    }

    public function prefers(string $widget): bool
    {
        return (bool) ($this->dashboard_preferences[$widget] ?? false);
    }
}
