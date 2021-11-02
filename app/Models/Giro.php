<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giro extends Model
{
    use HasFactory;


    protected $table = 'giro';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_bank',
        'id_customer',
        'id_transaction',
        'giro_number',
        'balance',
        'date_received',
        'id_payment_account',
        'cashed',
        'date_cashed',
        'jurnal_id'
    ];
    public function bank(){
        return $this->belongsTo('App\Models\Bank','id_bank','id');
    } 
    public function customer(){
        return $this->belongsTo('App\Models\Customer','id_customer','id');
    } 
    public function transaction(){
        return $this->belongsTo('App\Models\Transaction','id_transaction','id');
    } 
    public function paymentaccount(){
        return $this->belongsTo('App\Models\PaymentAccount','id_payment_account','id');
    } 
}
