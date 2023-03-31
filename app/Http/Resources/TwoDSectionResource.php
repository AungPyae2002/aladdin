<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TwoDSectionResource extends JsonResource
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
            'opening_time' => Carbon::parse($this->opening_date_time)->format('H:i A'),
            'set' => $this->ended ? $this->set : null,
            'value' => $this->ended ? $this->value : null,
            'winning_number' => $this->ended ? $this->winning_number : null,
            'has_set_value' => $this->type->has_set_value ?? false,
            'numbers' => collect(json_decode($this->numbers_info))->map(function($number,$index){
                return [
                    'id' => (string)($index),
                    'number' => (string)($index),
                    'percent' => $this->getPercent($index)
                ];
            })->toArray(),
            'ending' => $this->ending,
            'ended' => $this->ended,
            'multiply' => $this->multiply,
            'day' => Carbon::parse($this->opening_date_time)->format('A') == 'AM',
            'end_time' => $this->end_time
        ];
    }
}
