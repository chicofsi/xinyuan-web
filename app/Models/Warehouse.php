<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'warehouse';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jurnal_id',
        'id_area',
        'name',
        'address',
        'capacity',
    ];

    public function area(){
        return $this->belongsTo('App\Models\Area','id_area','id');
    } 

	public function warehouseproduct(){
        return $this->hasMany('App\Models\WarehouseProduct','id_warehouse','id');
    } 

    public function transaction(){
        return $this->hasMany('App\Models\Transaction','id_warehouse','id');
    } 

    public function purchase(){
        return $this->hasMany('App\Models\Purchase','id_warehouse','id');
    } 


}
