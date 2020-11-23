<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge badge-secondary">masok keranjang</span>';
        } elseif ($this->status == 1) {
            return '<span class="badge badge-primary">Dikonfirmasi pembeli</span>';
        } elseif ($this->status == 2) {
            return '<span class="badge badge-info">dibayar pembeli</span>';
        } elseif ($this->status == 3) {
            return '<span class="badge badge-warning">Dikirim penjual</span>';
        }
        return '<span class="badge badge-success">diterima pembeli</span>';
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function pesanan_detail()
    {
        return $this->hasMany('App\PesananDetail', 'pesanan_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
