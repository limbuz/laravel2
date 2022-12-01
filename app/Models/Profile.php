<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'profiles';

    protected $fillable = [
        'email',
        'password',
        'name',
        'second_name',
        'need_pages',
        'need_books',
        'timestamp_start',
        'timestamp_end'
    ];

    protected $hidden = [
        'password'
    ];

    protected $attributes = [
        'need_books' => 0
    ];
}
