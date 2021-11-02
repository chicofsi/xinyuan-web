<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPayment extends Model
{
    use HasFactory;

    protected $table = 'transaction_payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jurnal_id',
        'id_payment_account',
        'id_transaction',
        'date',
        'paid',
        'method'
    ];

    public function transaction(){
        return $this->belongsTo('App\Models\Transaction','id_transaction','id');
    } 
    public function paymentaccount(){
        return $this->belongsTo('App\Models\PaymentAccount','id_payment_account','id');
    } 
}
