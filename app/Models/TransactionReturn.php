<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionReturn extends Model
{
    use HasFactory;

    protected $table = 'transaction_return';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_transaction_refund',
        'id_transaction_details',
        'qty',
        'total_refund',
    ];

    public function transactionrefund(){
        return $this->belongsTo('App\Models\TransactionRefund','id_transaction_refund','id');
    } 
    public function transactiondetails(){
        return $this->belongsTo('App\Models\TransactionDetails','id_transaction_details','id');
    } 
}
