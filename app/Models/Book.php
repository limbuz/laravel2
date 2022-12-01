<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'books';

    protected $fillable = [
        'profile_id',
        'name',
        'poster',
        'pages',
        'genre',
        'is_read',
        'in_progress'
    ];
}
