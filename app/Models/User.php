<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
//    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'level_id',
        'is_active',
    ];

    public $incrementing = false;

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];
    protected $with = ['user_level', 'user_maps'];


    public function user_level()
    {
        return $this->belongsTo(UserLevel::class, 'level_id', 'level_id');
    }

    public function user_maps()
    {
        return $this->hasMany(UserMap::class, 'user_id');
    }


    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
//        $this->attributes = Hash::make($password);
    }
}
