<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;

    protected $table = 'purchase_details';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_purchase',
        'id_product',
        'quantity',
        'price',
        'total',
        'price_idr',
        'total_idr',
        'rates',
    ];

    public function purchase(){
        return $this->belongsTo('App\Models\Purchase','id_purchase','id');
    } 
    public function product(){
        return $this->belongsTo('App\Models\Product','id_product','id');
    } 
}
