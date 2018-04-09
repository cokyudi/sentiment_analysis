<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    public $timestamps = false;
    protected $table = 'pengaduan';

    public function komentars(){
        return $this->hasMany('App\Komentar', 'peng_id');
    }

    public function tindakLanjut(){
        return $this->hasOne('App\TindakLanjut', 'peng_id');
    }
}
