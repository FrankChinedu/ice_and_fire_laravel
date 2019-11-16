<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at', 'pivot'
    ];

    public function book() {
        return $this->hasMany('App\Model\Book');
    }
}
