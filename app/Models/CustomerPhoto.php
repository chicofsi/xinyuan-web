<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPhoto extends Model
{
    use HasFactory;

    protected $table = 'customer_photo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_customer',
        'id_customer_photo_category',
        'photo_url',
    ];

    public function customerphotocategory(){
        return $this->belongsTo('App\Models\CustomerPhotoCategory','id_customer_photo_category','id');
    } 
    public function customer(){
        return $this->belongsTo('App\Models\Customer','id_customer','id');
    } 
}
