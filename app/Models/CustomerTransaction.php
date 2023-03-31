<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTransaction extends Model
{
    use HasFactory;

    public const OUT = "-";
    public const IN = "+";

    public const PENDING = 1;
    public const APPROVED = 2;


    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function payment()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_id');
    }


    public function scopePending($query){
        return $query->where('status',self::PENDING);
    }

    public function scopeDeposit($query){
        return $query->where('type', '+');
    }

    public function scopeWithdraw($query)
    {
        return $query->where('type', '-');
    }


    public function transactionable()
    {
        return $this->morphTo();
    }
}
