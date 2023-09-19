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

    function getNoAttribute()
    {
        $no = str_pad($this->id, 4, '0', STR_PAD_LEFT);
        return 'TRX-' . $no;
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
