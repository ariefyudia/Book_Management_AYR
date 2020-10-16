<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';
    protected $fillable = [
        'name'
    ];

    public function book()
    {
        return $this->belongsToMany('App\Models\Book','book_authors','author_id','book_id');
    }
}