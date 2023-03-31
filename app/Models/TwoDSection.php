<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoDSection extends Model
{
    use HasFactory;

    protected $table = "twod_sections";
    protected $appends = ['ended','end_time'];

    public function type(){
        return $this->belongsTo(TwoDType::class,'twod_type_id');
    }

    public function schedule()
    {
        return $this->belongsTo(TwoDSchedule::class, 'twod_schedule_id');
    }

    public function customerTransactions(){
        return $this->morphMany(CustomerTransaction::class,'transactionable');
    }

    public function bettingLogs(){
        return $this->hasMany(TwoDBettingLog::class,'twod_section_id');
    }

    public function getMaximumAmount($number){
        return json_decode($this->numbers_info)->$number->maximum_amount;
    }

    public function getTotalAmount($number){
        return $this->bettingLogs()->where('bet_number',$number)->sum('amount');
    }

    public function getPercent($number)
    {
        $maximum_amount = $this->getMaximumAmount($number);
        $total_amount = $this->getTotalAmount($number);
        if ($maximum_amount == 0 || $total_amount == 0) {
            return 0;
        } else {
            return ($total_amount / $maximum_amount) * 100;
        }
    }

    public function getEndingAttribute(){
        return Carbon::now()->gt(Carbon::parse($this->opening_date_time)->subMinutes(15));
    }

    public function getEndedAttribute(){
        return Carbon::now()->gt(Carbon::parse($this->opening_date_time));
    }

    public function getEndTimeAttribute(){
        return Carbon::parse($this->opening_date_time)->subMinutes(15)->format('H:i');
    }

    public function getTitleAttribute(){
        return $this->type->name.' '.Carbon::parse($this->opening_date_time)->format('h:i A');
    }
}
