<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['name', 'description', 'image','alamat'];
    public function user()
    {
        return $this->hasOne('App\User', 'customer_id', 'id');
    }
}
