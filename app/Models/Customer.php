<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_area',
        'invited_by',
        'customer_number',
        'company_name',
        'company_address',
        'company_phone',
        'company_npwp',
        'administrator_name',
        'administrator_id',
        'administrator_birthdate',
        'administrator_npwp',
        'administrator_phone',
        'administrator_address',
        'id_level',
        'jurnal_id'
    ];

    public function customerphoto(){
        return $this->hasMany('App\Models\CustomerPhoto','id_customer','id');
    }

    public function area(){
        return $this->belongsTo('App\Models\Area','id_area','id');
    } 

	public function transaction(){
        return $this->hasMany('App\Models\Transaction','id_customer','id');
    } 

    public function sales(){
        return $this->belongsTo('App\Models\Sales','invited_by','id');
    } 
    public function customerlevel(){
        return $this->belongsTo('App\Models\CustomerLevel','id_level','id');
    } 

}
