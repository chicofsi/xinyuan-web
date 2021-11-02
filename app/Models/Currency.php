<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currency';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'jurnal_id',
        'symbol',
    ];

    public function purchase(){
        return $this->hasMany('App\Models\Purchase','id_currency','id');
    }

}
