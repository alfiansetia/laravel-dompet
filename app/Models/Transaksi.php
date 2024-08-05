<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'amount'    => 'integer',
        'cost'      => 'integer',
        'revenue'   => 'integer',
    ];

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('images/transaksi/' . $value))) {
            return url('/images/transaksi/' . $value);
        } else {
            return url('/images/default/noimage.jpg');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function from()
    {
        return $this->belongsTo(Dompet::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(Dompet::class, 'to_id');
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['number'])) {
            $query->where('number', 'like', '%' . $filters['number'] . '%');
        }
        if (isset($filters['user_id'])) {
            $query->where('user_id',  $filters['user_id']);
        }
        if (isset($filters['from_id'])) {
            $query->where('from_id',  $filters['from_id']);
        }
        if (isset($filters['to_id'])) {
            $query->where('to_id',  $filters['to_id']);
        }
        if (isset($filters['status'])) {
            $query->where('status',  $filters['status']);
        }
        if (isset($filters['order_id_asc'])) {
            $query->orderBy('id', 'asc');
        }
        if (isset($filters['order_id_desc'])) {
            $query->orderBy('id', 'desc');
        }
    }
}
