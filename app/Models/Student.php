<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Student extends Model implements HasMedia
{
    use InteractsWithMedia;
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
