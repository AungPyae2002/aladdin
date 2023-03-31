<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function scopeSort($query)
    {
        return $query->orderBy('sort', 'desc');
    }

    public function scopeActive($query){
        return $query->where('status',1);
    }
}
