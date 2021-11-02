<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesTarget extends Model
{
    use HasFactory;

    protected $table = 'sales_target';


    protected $primaryKey = null;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_sales',
        'sales_target',
        'billing_target',
    ];

    public function sales(){
        return $this->belongsTo('App\Models\Sales','id_sales','id');
    } 
}
