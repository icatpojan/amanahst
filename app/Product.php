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
    protected $guarded = [];
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }
    public function shop()
    {
        return $this->belongsTo(shop::class);
    }
}
