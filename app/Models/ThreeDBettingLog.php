<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ThreeDSection;
use Carbon\Carbon;

class ThreeDBettingLog extends Model
{
    use HasFactory;
    protected $table = 'threed_betting_logs';
    protected $appends = ['winning_amount', 'title'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function section()
    {
        return $this->belongsTo(ThreeDSection::class, 'threed_section_id');
    }

    public function getWinningAmountAttribute()
    {
        if ($this->section->winning_number == $this->bet_number) {
            $multiply = $this->section->multiply;
        } else {
            $multiply = 0;
        }
        return $multiply * $this->amount;
    }

    public function getTitleAttribute()
    {
        return $this->section ? '3D '.Carbon::parse($this->section->opening_date_time)->format('Y-m-d') : null;
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $customer = $model->customer;
            $paying_amount = $model->amount;
            $customer->substract($paying_amount);
        });
    }
}
