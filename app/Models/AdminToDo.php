<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminToDo extends Model
{
    use HasFactory;

    protected $table = 'admin_to_do';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_admin',
        'message',
        'done',
        'done_date',
    ];

    public function sales(){
        return $this->belongsTo('App\Models\Admin','id_admin','id');
    } 
}
