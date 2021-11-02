<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWeight extends Model
{
    use HasFactory;


    protected $table = 'product_weight';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'weight',
    ];

    public function product(){
        return $this->hasMany('App\Models\Product','id_weight','id');
    }
}
