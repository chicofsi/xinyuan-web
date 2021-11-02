<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLevel extends Model
{
    use HasFactory;


    protected $table = 'customer_level';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level',
        'tempo_limit',
        'loan_limit',
        'nice',
    ];

    public function customer(){
        return $this->hasMany('App\Models\Customer','id_level','id');
    }
}
