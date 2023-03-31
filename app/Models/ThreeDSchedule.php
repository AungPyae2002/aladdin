<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreeDSchedule extends Model
{
    use HasFactory;
    protected $table = 'threed_schedules';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
