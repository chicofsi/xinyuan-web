<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;


    protected $table = 'product_size';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'height',
        'width'
    ];

    public function product(){
        return $this->hasMany('App\Models\Product','id_size','id');
    }
}
