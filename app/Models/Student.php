<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{

    protected $guarded = [];

    public function classes()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
    public function stage()
    {
        return $this->hasOneThrough(Stage::class, SchoolClass::class, 'id', 'id', 'class_id', 'stage_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
