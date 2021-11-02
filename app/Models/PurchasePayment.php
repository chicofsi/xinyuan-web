<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    use HasFactory;

    protected $table = 'purchase_payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jurnal_id',
        'id_payment_account',
        'id_purchase',
        'date',
        'paid',
        'rates',
        'paid_idr',
    ];

    public function purchase(){
        return $this->belongsTo('App\Models\Purchase','id_purchase','id');
    } 
    public function paymentaccount(){
        return $this->belongsTo('App\Models\PaymentAccount','id_payment_account','id');
    } 
}
