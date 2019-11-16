<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name', 'isbn', 'number_of_pages', 'publisher', 'release_date', 'country'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function authors(){
       return $this->belongsToMany('App\Model\Author');
    }
}
