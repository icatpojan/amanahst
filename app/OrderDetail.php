<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
	protected $fillable=['jumlah_pesan','price'];
	
    public function product()
	{
	      return $this->belongsTo('App\Product','product_id', 'id');
	}

	public function order()
	{
	      return $this->belongsTo('App\Order','order_id', 'id');
    }
    
}
