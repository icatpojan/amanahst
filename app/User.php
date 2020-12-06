<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject 
{
    use Notifiable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','alamat','image','nomor_telpon','kode','role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'socialite_name', 'socialite_id'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function product()
    {
        return $this->hasMany('App\Product', 'customer_id', 'id');
    }
    public function order()
    {
        return $this->hasMany('App\Order', 'customer_id', 'id');
    }
    public function message() 
    {
         return $this->hasMany('App\Message', 'from', 'id');
    }
    public function pesan() 
    {
         return $this->hasMany('App\Message', 'to', 'id');
    }
    public function komentar() 
    {
         return $this->hasMany('App\Komentar', 'to', 'id');
    }
    public function shop()
    {
        return $this->hasOne('App\Shop', 'customer_id', 'id');
    }
}