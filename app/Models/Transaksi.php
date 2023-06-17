<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function from()
    {
        return $this->belongsTo(Dompet::class, 'id');
    }

    function to()
    {
        return $this->belongsTo(Dompet::class, 'id');
    }
}
