<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaProductStock extends Model
{
    use HasFactory;

    protected $table = 'area_product_stock';

    protected $primaryKey = null;
    public $incrementing = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_product',
        'id_area',
        'stock',
        'on_the_way',
        'on_production',
        'preorder',
        'total',
    ];

    public function area(){
        return $this->belongsTo('App\Models\Area','id_area','id');
    } 
    public function product(){
        return $this->belongsTo('App\Models\Product','id_product','id');
    } 
}
