<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',   
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Auto-generate username 
    protected static function booted()
    {
        static::creating(function ($user) {
            if (!empty($user->username)) return;

            $base = Str::slug($user->name, '');   
            if ($base === '') $base = 'user';

            $username = $base;
            $i = 1;

            while (static::where('username', $username)->exists()) {
                $username = $base.$i; // ankitkumar2, ankitkumar3...
                $i++;
            }

            $user->username = $username;
        });
    }

    public function portfolios()
    {
        return $this->hasMany(\App\Models\Portfolio::class);
    }
}