<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['id','name', 'description', 'image','alamat','customer_id'];
    public function user()
    {
        return $this->belongsTo('App\User', 'customer_id', 'id');
    }
    public function product()
    {
        return $this->hasmany('App\Product', 'shop_id', 'id');
    }

}
