<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $type = null;
        switch($this->type){
            case "App\Notifications\WinningNotification" : $type = "win";
        }
        return [
            "id" => $this->id,
            "type" => $type,
            "content" => $this->data["content"],
            "created_at" => $this->created_at->format('Y-m-d H:i A')
        ];
    }
}
