<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

class ComplaintTicket extends Model
{
    use HasFactory;

    protected $table = 'complaint_tickets';
    protected $primaryKey = 'ticket_id';
    protected $fillable = [
        'ticket_code',
        'nip',
        'unit_kerja_kode',
        'employee_name',
        'employee_position',
        'employee_unit',
        'employee_satker',
        'ticket_title',
        'ticket_desc',
        'ticket_date',
        'ticket_status',
        'created_at',
        'updated_at'
    ];


    protected $with = ['user_map', 'images', 'feedbacks', 'rating'];

    public final function scopeSearch($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where("ticket_title", "like", "%$search%")
                    ->orWhere("ticket_desc", "like", "%$search%");
            });
        });
    }

    public function getRouteKeyName()
    {
        return 'ticket_code';
    }

    public function images()
    {
        return $this->hasMany(ComplaintImage::class, 'ticket_code', 'ticket_code');
    }

    public function user_map()
    {
        return $this->belongsTo(UserMap::class, 'unit_kerja_kode', 'unit_kerja_kode');
    }

    public function feedbacks()
    {
        return $this->hasMany(FeedbackTicket::class, 'ticket_code', 'ticket_code');
    }

    public function rating()
    {
        return $this->hasOne(RatingTicket::class, 'ticket_code', 'ticket_code');
    }
}
