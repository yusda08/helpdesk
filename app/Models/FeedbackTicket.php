<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackTicket extends Model
{
    use HasFactory;

    protected $table = 'feedback_tickets';
    protected $primaryKey = 'feedback_id';
    protected $fillable = [
        'nip',
        'user_id',
        'ticket_code',
        'feedback_desc',
        'created_at',
        'updated_at'
    ];


}
