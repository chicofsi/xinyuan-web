<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPhotoCategory extends Model
{
    use HasFactory;

    protected $table = 'customer_photo_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function customerphoto(){
        return $this->hasMany('App\Models\CustomerPhoto','id_customer_photo_category','id');
    }
}
