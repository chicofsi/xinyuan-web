<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;


    protected $table = 'transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_number',
        'id_sales',
        'id_customer',
        'id_warehouse',
        'date',
        'payment',
        'payment_deadline',
        'paid',
        'total_payment',
        'jurnal_id',
        'id_company'
    ];

    public function transactiondetails(){
        return $this->hasMany('App\Models\TransactionDetails','id_transaction','id');
    }
    public function transactionpayment(){
        return $this->hasMany('App\Models\TransactionPayment','id_transaction','id');
    }
    public function transactionrefund(){
        return $this->hasMany('App\Models\TransactionRefund','id_transaction','id');
    }
    public function giro(){
        return $this->hasMany('App\Models\Giro','id_transaction','id');
    }
    public function sales(){
        return $this->belongsTo('App\Models\Sales','id_sales','id');
    } 
    public function customer(){
        return $this->belongsTo('App\Models\Customer','id_customer','id');
    } 
    public function company(){
        return $this->belongsTo('App\Models\Company','id_company','id');
    } 
    public function warehouse(){
        return $this->belongsTo('App\Models\Warehouse','id_warehouse','id');
    } 
}
