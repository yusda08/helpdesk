<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApik extends Model
{
    use HasFactory;

    protected $connection = 'mysql_apik';
    protected $table = 'user';
    protected $primaryKey = 'nip';
    protected $fillable = ['nip', 'uuid', 'created_at', 'updated_at'];
    public $incrementing = false;
}
