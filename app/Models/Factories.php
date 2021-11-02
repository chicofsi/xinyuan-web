<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factories extends Model
{
    use HasFactory;


    protected $table = 'factories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function product(){
        return $this->hasMany('App\Models\Product','id_factories','id');
    }
}
