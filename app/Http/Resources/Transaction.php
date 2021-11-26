<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
use App\Models\PaymentAccount;
use App\Http\Resources\PaymentAccount as PaymentAccountResource;
use App\Http\Resources\Giro as GiroResource;
use App\Http\Resources\TransactionPayment as TransactionPaymentResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $transactiondetails=[];
        if(! $this->transactiondetails->isEmpty()){
            foreach ($this->transactiondetails as $key => $value) {
                $product=new ProductResource(Product::where('id',$value->id_product)->first());
                $transactiondetails[$key]=[
                    'product' => $product,
                    'quantity' =>$value->quantity, 
                    'price' =>$value->price, 
                    'subtotal' =>$value->total, 
                ];
            }
        }

        $transactionpayment=[];
        if(! $this->transactionpayment->isEmpty()){
            foreach ($this->transactionpayment as $key => $value) {
                $transactionpayment[$key]=new TransactionPaymentResource($value);
            }
        }
        $giro=[];
        if(! $this->giro->isEmpty()){
            foreach ($this->giro as $key => $value) {
                $giro[$key]=new GiroResource($value);
            }
        }
        $datedeadline=strtotime($this->payment_deadline);
        $date=strtotime($this->date);

        $datediff = $datedeadline - $date;

        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'sales' => $this->sales->name,
            'company' => $this->company->display_name,
            'warehouse' => $this->warehouse->name,
            'customer' => $this->customer->company_name,
            'date' => $this->date,
            'payment' => $this->payment,
            'payment_period' => round($datediff / (60 * 60 * 24)),
            'payment_deadline' => $this->payment_deadline,
            'paid' => $this->paid,
            'debt' => ($this->total_payment - $this->paid),
            'debt' => ($this->total_payment - $this->paid),
            'total_payment' => $this->total_payment,
            'transactiondetails' => $transactiondetails,
            'transactionpayment' => $transactionpayment,
            'giro' => $giro
        ];
    }
}
