<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge badge-secondary">Baru</span>';
        } elseif ($this->status == 1) {
            return '<span class="badge badge-primary">Dikonfirmasi customer</span>';
        } elseif ($this->status == 2) {
            return '<span class="badge badge-info">Proses</span>';
        } elseif ($this->status == 3) {
            return '<span class="badge badge-warning">Dikirim</span>';
        }
        return '<span class="badge badge-success">Selesai</span>';
    }
    public function user()
	{
	      return $this->belongsTo('App\User','user_id', 'id');
	}

	public function pesanan_detail() 
	{
	     return $this->hasMany('App\PesananDetail','pesanan_id', 'id');
	}

}
