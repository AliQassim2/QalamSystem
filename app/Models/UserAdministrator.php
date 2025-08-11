<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAdministrator extends Model
{
    protected $table = 'user_administrator';

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
