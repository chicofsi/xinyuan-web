<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    use HasFactory;

    protected $table = 'payment_account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_bank','account_name','account_number','jurnal_id'
    ];

   
    public function bank(){
        return $this->belongsTo('App\Models\Bank','id_bank','id');
    }

    public function payment(){
        return $this->hasMany('App\Models\Payment','id_payment_account','id');
    }

}
