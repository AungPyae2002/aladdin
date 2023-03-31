<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreeDSectionResource extends JsonResource
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
            'winning_number' => $this->winning_number,
            'opening_date_time' => $this->opening_date_time,
            'date' => Carbon::parse($this->opening_date_time)->format('Y-m-d'),
            'multiply' => $this->multiply,
            'numbers' => collect(json_decode($this->numbers_info))->map(function ($number, $index) {
                return [
                    'id' => (string)($index),
                    'number' => (string)($index),
                    'percent' => $this->getPercent($index)
                ];
            })->toArray(),
        ];
    }
}
