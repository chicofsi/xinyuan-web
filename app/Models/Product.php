<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_factories',
        'id_type',
        'id_size',
        'id_weight',
        'id_gross_weight',
        'id_colour',
        'id_logo',
        'cost',
        'still_available',
        'jurnal_id'
    ];

    public function factories(){
        return $this->belongsTo('App\Models\Factories','id_factories','id');
    } 
    public function type(){
        return $this->belongsTo('App\Models\ProductType','id_type','id');
    } 
    public function size(){
        return $this->belongsTo('App\Models\ProductSize','id_size','id');
    } 
    public function colour(){
        return $this->belongsTo('App\Models\ProductColour','id_colour','id');
    } 
    public function logo(){
        return $this->belongsTo('App\Models\ProductLogo','id_logo','id');
    } 
    public function weight(){
        return $this->belongsTo('App\Models\ProductWeight','id_weight','id');
    } 
    public function grossweight(){
        return $this->belongsTo('App\Models\ProductGrossWeight','id_gross_weight','id');
    } 

    public function transactiondetails(){
        return $this->hasMany('App\Models\TransactionDetails','id_product','id');
    }

    public function warehouseproduct(){
        return $this->hasMany('App\Models\WarehouseProduct','id_product','id');
    }
    public function productphoto(){
        return $this->hasMany('App\Models\ProductPhoto','id_product','id');
    }

    public function purchasedetails(){
        return $this->hasMany('App\Models\PurchaseDetails','id_product','id');
    }
    
}
