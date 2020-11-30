<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge badge-secondary">Draft</span>';
        }
        return '<span class="badge badge-success">Aktif</span>';
    }
    //relasi ke tabel category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    protected $fillable = ['customer_id','name','description','price','stock','weight','category_id','image','status','slug'];
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }
    public function user()
    {
        return $this->belongsTo('App\User','customer_id', 'id');
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function komentar()
    {
        return $this->hasMany(komentar::class);
    }
    public function orderdetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
