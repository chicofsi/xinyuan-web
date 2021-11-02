<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGrossWeight extends Model
{
    use HasFactory;


    protected $table = 'product_gross_weight';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gross_weight',
    ];

    public function product(){
        return $this->hasMany('App\Models\Product','id_gross_weight','id');
    }
}
