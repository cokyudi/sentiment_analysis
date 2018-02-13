<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable {
	public $timestamps = false;
    protected $table = 'admin';
}
