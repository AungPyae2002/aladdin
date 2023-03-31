<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoDSchedule extends Model
{
    use HasFactory;

    protected $table = "twod_schedules";

    public function type(){
        return $this->belongsTo(TwoDType::class,'twod_type_id');
    }

    public function scopeActive($query){
        return $query->where('status',1);
    }
}
