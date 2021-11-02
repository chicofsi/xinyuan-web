<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Sales extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;

    protected $table = 'sales';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_area',
        'name',
        'password',
        'password_unhash',
        'email',
        'address',
        'phone',
        'photo_url',

    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    
    public function area(){
        return $this->belongsTo('App\Models\Area','id_area','id');
    }

    public function customer(){
        return $this->hasMany('App\Models\Customer','invited_by','id');
    }

    public function transaction(){
        return $this->hasMany('App\Models\Transaction','id_sales','id');
    } 
    
    public function target(){
        return $this->hasOne('App\Models\SalesTarget','id_sales','id');
    } 

    public function todo(){
        return $this->hasMany('App\Models\SalesToDo','id_sales','id');
    } 
}
