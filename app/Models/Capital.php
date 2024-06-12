<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'amount'    => 'integer',
    ];

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('images/capital/' . $value))) {
            return url('/images/capital/' . $value);
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
}
