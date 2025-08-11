<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolManager extends Model
{
    protected $table = 'school_manager';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
