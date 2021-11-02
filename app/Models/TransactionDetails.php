<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;

    protected $table = 'transaction_details';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_transaction',
        'id_product',
        'quantity',
        'price',
        'total',
    ];

    public function transaction(){
        return $this->belongsTo('App\Models\Transaction','id_transaction','id');
    } 
    public function product(){
        return $this->belongsTo('App\Models\Product','id_product','id');
    } 
}
