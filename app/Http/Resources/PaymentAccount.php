<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;

class PaymentAccount extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'account_name' => $this->account_name,
            'account_number' => $this->account_number,
            'bank' => $this->bank->name
        ];
    }
}
