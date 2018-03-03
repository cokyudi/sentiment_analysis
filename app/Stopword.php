<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stopword extends Model
{
    public $timestamps = false;
    protected $table = 'stopword';
}
