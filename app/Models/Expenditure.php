<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'amount'    => 'integer',
        'user_id'   => 'integer',
        'dompet_id' => 'integer',
    ];

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('images/expenditure/' . $value))) {
            return url('/images/expenditure/' . $value);
        } else {
            return url('/images/default/noimage.jpg');
        }
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function dompet()
    {
        return $this->belongsTo(Dompet::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['number'])) {
            $query->where('number', 'like', '%' . $filters['number'] . '%');
        }
        if (isset($filters['user_id'])) {
            $query->where('user_id',  $filters['user_id']);
        }
        if (isset($filters['status'])) {
            $query->where('status',  $filters['status']);
        }
    }
}
