<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColour extends Model
{
    use HasFactory;


    protected $table = 'product_colour';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function product(){
        return $this->hasMany('App\Models\Product','id_colour','id');
    }
}
