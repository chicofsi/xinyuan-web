<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'area';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'dashboard'
    ];

    public function areaproductstock(){
        return $this->hasMany('App\Models\AreaProductStock','id_area','id');
    }
    public function customer(){
        return $this->hasMany('App\Models\Customer','id_area','id');
    }

    public function sales(){
        return $this->hasMany('App\Models\Sales','id_area','id');
    }

    public function warehouse(){
        return $this->hasMany('App\Models\Warehouse','id_area','id');
    }
}
