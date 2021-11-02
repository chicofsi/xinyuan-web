<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasFactory;

    protected $table = 'product_photo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_product',
        'photo_url',
    ];

    public function product(){
        return $this->belongsTo('App\Models\Product','id_product','id');
    } 
}
