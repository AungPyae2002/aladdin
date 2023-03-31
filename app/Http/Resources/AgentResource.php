<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'balance' => $this->balance,
            'phone' => $this->phone,
            'contact' => $this->contact,
            'current_mode' => $this->current_mode,
            'current_mode_approved' => $this->current_mode_approved,
            'image' => asset($this->image),
            'minimum_amount' => $this->minimum_amount,
            'maximum_amount' => $this->maximum_amount,
            'duration' => $this->duration,
            'has_level2_account' => $this->has_level2_account,
            'approved' => $this->approved,
            'payment_methods' => $this->paymentMethods->map(function($p){
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'image' => asset($p->image),
                    'receiver_account_phone' => $p->pivot->receiver_account_phone,
                    'receiver_account_name' => $p->pivot->receiver_account_name,
                ];
            })


        ];
    }
}
