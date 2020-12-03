<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['name', 'description', 'image','alamat','customer_id'];
    public function user()
    {
        return $this->belongsTo('App\User', 'customer_id', 'id');
    }
}
