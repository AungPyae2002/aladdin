<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $transaction_type = $title = $to = null;
        switch($this->transactionable_type){
            case "App\Models\TwoDSection" : {
                $transaction_type = "ဆုကြေးငွေ";
                $title = $this->transactionable->title ?? null;
            };break;
            case "App\Models\ThreeDSection": {
                    $transaction_type = "ဆုကြေးငွေ";
                    $title = $this->transactionable->title ?? null;
                };
                break;
            case "App\Models\Agent": {
                    if($this->type == '-'){
                        $transaction_type = "ဆုကြေးငွေ";
                    }elseif($this->type == '+'){
                        $transaction_type = "ဆုကြေးငွေ";
                    }
                    $to = $this->receiver_account_phone ?? null;
                };
            break;
        }
        return [
            "id" => $this->transaction_id,
            "type" => $this->type,
            "amount" => $this->amount,
            "transaction_type" => $transaction_type,
            "created_at" => $this->created_at,
            "date_time" => $this->created_at->format('d/m h:i A'),
            "title" => $title,
            "to" => $to
        ];
    }
}
