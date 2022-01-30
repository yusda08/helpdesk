<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

class ComplaintTickets extends Model
{
    use HasFactory;

    protected $table = 'complaint_tickets';
    protected $primaryKey = 'ticket_id';
    protected $fillable = [
        'ticket_code',
        'nip',
        'employee_name',
        'employee_position',
        'employee_unit',
        'ticket_title',
        'ticket_desc',
        'ticket_date',
        'ticket_status',
        'created_at',
        'updated_at'
    ];

//    protected $hidden = [
//        'created_at',
//        'updated_at'
//    ];

    public final function scopeSearch($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where("ticket_title", "like", "%$search%")
                    ->orWhere("ticket_desc", "like", "%$search%");
            });
        });
    }
}
