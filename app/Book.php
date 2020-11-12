<?php

namespace App;

use Hamcrest\Description;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'Description',
        'author',
        'publisher',
        'year'

    ];
}
