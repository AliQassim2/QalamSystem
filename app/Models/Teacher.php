<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
