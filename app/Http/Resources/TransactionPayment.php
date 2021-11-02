<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PaymentAccount;
use App\Http\Resources\PaymentAccount as PaymentAccountResource;

class TransactionPayment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $paymentaccount=new PaymentAccountResource(PaymentAccount::where('id',$this->id_payment_account)->first());


        return [
            'id' => $this->id,
            'date' => $this->date,
            'paid' => $this->paid,
            'paymentaccount' => $paymentaccount,
            'method' => $this->method
        ];
    }
}
