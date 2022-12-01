<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * @var \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    protected $table = 'profits';
}
