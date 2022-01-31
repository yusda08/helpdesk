<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintImage extends Model
{
//    use HasFactory;

    protected $table = 'complaint_images';
    protected $primaryKey = 'image_id';
    protected $fillable = ['ticket_code', 'file_image', 'created_at', 'updated_at'];

    public function getRouteKeyName()
    {
        return 'ticket_code';
    }
}
