<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PaymentAccount;
use App\Models\Bank;

class Giro extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $bank=Bank::where('id',$this->id_bank)->first();
        $paymentaccount=[];
        if($this->id_payment_account!=null){
            $paymentaccount=PaymentAccount::where('id',$this->id_payment_account)->first();
        }
        return [
            'id' => $this->id,
            'giro_number' => $this->giro_number,
            'balance' => $this->balance,
            'date_received' => $this->date_received,
            'cashed' => $this->cashed,
            'date_cashed' => $this->date_cashed,
            'bank' => $bank->name,
            'paymentaccount' => $paymentaccount
        ];
    }
}
