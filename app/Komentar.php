<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    public function product()
	{
	      return $this->belongsTo('App\Product','product_id', 'id');
    }
    public function user()
	{
	      return $this->belongsTo('App\User','customer_id', 'id');
	}
}
