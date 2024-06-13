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

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('images/dompet/' . $value))) {
            return url('/images/dompet/' . $value);
        } else {
            return url('/images/default/noimage.jpg');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
    }
}
