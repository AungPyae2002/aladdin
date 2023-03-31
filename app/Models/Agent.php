<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Agent extends Model
{
    use HasFactory,HasApiTokens;

    public const BUYING_MODE = 1;
    public const SELLING_MODE = 2;

    protected $casts = [
        'approved_at' => 'date'
    ];

    public function customerTransactions()
    {
        return $this->morphMany(CustomerTransaction::class, 'transactionable');
    }


    public function scopePending($query){
        return $query->where('approved',0);
    }

    public function scopeSellingPending($query)
    {
        return $query->where('current_mode_approved', 0)->where('current_mode',2);
    }

    public function scopeBuyingPending($query)
    {
        return $query->where('current_mode_approved', 0)->where('current_mode', 1);
    }

    public function paymentMethods(){
        return $this->belongsToMany(PaymentMethod::class,'agent_payments','payment_method_id','agent_id')->withPivot('receiver_account_name','receiver_account_phone');
    }

    public function addBalance($amount){
        return Agent::where('id',$this->id)->increment('balance',$amount);
    }

    public function substractBalance($amount){
        return Agent::where('id', $this->id)->decrement('balance', $amount);
    }
}
