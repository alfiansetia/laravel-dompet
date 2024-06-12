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
}
