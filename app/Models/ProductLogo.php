<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLogo extends Model
{
    use HasFactory;


    protected $table = 'product_logo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'photo_url'
    ];

    public function product(){
        return $this->hasMany('App\Models\Product','id_logo','id');
    }
}
