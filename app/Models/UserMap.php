<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMap extends Model
{
    use HasFactory;

    protected $table = 'user_maps';
    protected $primaryKey = 'map_id';
    protected $guarded = ['map_id'];

//    protected $with = ['user'];

//    public function user()
//    {
//        return $this->belongsTo(User::class, 'user_id', 'id');
//    }

    public function complaint_ticket()
    {
        return $this->hasMany(ComplaintTicket::class, 'unit_kerja_kode', 'unit_kerja_kode');
    }

}
