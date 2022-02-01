<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMap extends Model
{
    use HasFactory;

    protected $table = 'user_maps';
    protected $guarded = ['map_id'];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

}
