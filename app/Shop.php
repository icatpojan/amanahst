<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['title', 'content', 'author','tag','foto'];
    public function customer()
    {
        return $this->hasOne(customer::class);
    }
}
