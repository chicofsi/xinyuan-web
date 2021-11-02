<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;


    protected $table = 'company';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'active'
    ];

    public function transaction(){
        return $this->hasMany('App\Models\Transaction','id_company','id');
    }
}
