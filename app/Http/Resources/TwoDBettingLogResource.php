<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TwoDBettingLogResource extends JsonResource
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
            'title' => $this->title,
            'multiply' => $this->section->multiply ?? null,
            'bet_number' => $this->bet_number,
            'amount' => $this->amount,
            'created_at' => $this->created_at->format('Y-m-d H:i A')
        ];
    }
}
