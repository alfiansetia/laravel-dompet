<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comp extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function getLogoAttribute($value)
    {
        if ($value) {
            return url('/images/company/' . $value);
        } else {
            return url('/images/company/logo.png');
        }
    }

    public function getFavAttribute($value)
    {
        if ($value) {
            return url('/images/company/' . $value);
        } else {
            return url('/images/company/favicon.ico');
        }
    }
}
