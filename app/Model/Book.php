<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name', 'isbn', 'authors', 'number_of_pages', 'publisher', 'release_date'
    ];
}
