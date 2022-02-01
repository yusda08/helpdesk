<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerjaApik extends Model
{
    use HasFactory;

    protected $connection = 'mysql_presensi';
    protected $table = 'tb_unit_kerja';
    protected $primaryKey = 'unit_kerja_kode';
    protected $fillable = ['unit_kerja_kode', 'unit_kerja_nama', 'unit_kerja_lat', 'unit_kerja_long', 'unit_kerja_radius'];
    public $incrementing = false;

}
