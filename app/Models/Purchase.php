<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;


    protected $table = 'purchase';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_number',
        'id_factories',
        'id_warehouse',
        'date',
        'payment',
        'payment_deadline',
        'paid_idr',
        'paid',
        'total_payment',
        'total_payment_idr',
        'jurnal_id',
        'id_currency'
    ];

    public function purchasedetails(){
        return $this->hasMany('App\Models\PurchaseDetails','id_purchase','id');
    }
    public function purchasepayment(){
        return $this->hasMany('App\Models\PurchasePayment','id_purchase','id');
    }
    public function factories(){
        return $this->belongsTo('App\Models\Factories','id_factories','id');
    } 
    public function currency(){
        return $this->belongsTo('App\Models\Currency','id_currency','id');
    } 
}
