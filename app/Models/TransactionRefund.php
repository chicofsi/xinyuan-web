<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionRefund extends Model
{
    use HasFactory;

    protected $table = 'transaction_refund';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_transaction',
        'cashback',
        'total_cashback',
        'date',
        'note',
        'id_transaction_payment'
    ];

    public function transaction(){
        return $this->belongsTo('App\Models\Transaction','id_transaction','id');
    } 
    public function transactionpayment(){
        return $this->belongsTo('App\Models\TransactionPayment','id_transaction_payment','id');
    } 
    public function transactionreturn(){
        return $this->hasMany('App\Models\TransactionReturn','id_transaction_refund','id');
    } 
}
