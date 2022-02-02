<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingTicket extends Model
{
    use HasFactory;

    protected $table = 'rating_tickets';
    protected $primaryKey = 'rating_id';
    protected $fillable = ['ticket_code', 'rating_desc', 'rating_star', 'created_at', 'updated_at'];



}
