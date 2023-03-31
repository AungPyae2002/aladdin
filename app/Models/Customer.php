<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens,HasFactory,Notifiable;

    protected $appends = ['avatar','balance'];

    protected $hidden = ['password'];

    public function betting_logs_2d(){
        return $this->belongsToMany(TwoDBettingLog::class,'');
    }

    public function getAvatarAttribute(){
        return $this->image ? asset($this->image) : asset('profile.png');
    }

    public function balances(){
        return $this->hasMany(CustomerBalance::class,'customer_id');
    }

    public function transactions(){
        return $this->hasMany(CustomerTransaction::class,'customer_id');
    }

    public function getBalanceAttribute(){
        return $this->balances()->sum('amount');
    }

    public function substract($paying_amount){
        while ($balance = $this->balances()->orderBy('id')->first()) {
            if ($balance->amount >= $paying_amount) {
                $balance->decrement('amount', $paying_amount);
                $paying_amount = 0;
                break;
            } else {
                $balance->decrement('amount', $balance->amount);
                $paying_amount = $balance->amount;
            }
        }
    }
}
