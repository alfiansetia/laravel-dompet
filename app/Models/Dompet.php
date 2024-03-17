<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dompet extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'saldo'    => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
