<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function dompet()
    {
        return $this->belongsTo(Dompet::class);
    }
}
