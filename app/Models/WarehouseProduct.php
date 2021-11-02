<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
    use HasFactory;

    protected $table = 'warehouse_product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_warehouse',
        'id_product',
        'quantity',
    ];

    public function warehouse(){
        return $this->belongsTo('App\Models\Warehouse','id_warehouse','id');
    } 

    public function product(){
        return $this->belongsTo('App\Models\Product','id_product','id');
    } 

}
