<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admins extends Model
{
    public $table = 'admins';
    protected $hidden = ['password', 'remember_token'];
}
