<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Read extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'reads';

    protected $fillable = [
        'profile_id',
        'book_id',
        'pages',
        'timestamp'
    ];

    protected $attributes = [
        'book_id' => null
    ];
}
