<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesToDo extends Model
{
    use HasFactory;

    protected $table = 'sales_to_do';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_sales',
        'message',
        'done',
        'done_date',
    ];

    public function sales(){
        return $this->belongsTo('App\Models\Sales','id_sales','id');
    } 
}
