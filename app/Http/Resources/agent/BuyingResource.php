<?php

namespace App\Http\Resources\agent;

use App\Http\Resources\CustomerResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if(Carbon::parse($this->created_at)->lt(Carbon::now()->subMinutes($request->user()->duration))){
            $remaining_time = 0;
        }else{
            $remaining_time = Carbon::parse($this->created_at)->diffInSeconds(Carbon::now()->subMinutes($request->user()->duration));
        }

        return [
            'transaction_id' => $this->transaction_id,
            'user' => new CustomerResource($this->customer),
            'amount' => $this->amount,
            'remaining_time' => $remaining_time <= 0 ? 0 : $remaining_time,
            'payment' => $this->payment,
            'receiver_account_phone' => $this->receiver_account_phone,
            'receiver_account_name' => $this->receiver_account_name,

        ];
    }
}
