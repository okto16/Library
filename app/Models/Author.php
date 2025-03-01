<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $guarded = [''];
    use HasFactory;
    public function books()
    {
        return $this->hasMany('App\Models\Book', 'author_id');
    }
}
