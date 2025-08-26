<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model implements HasMedia
{
    use InteractsWithMedia;
    use LogsActivity;

    // Configure what gets logged
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // log all attributes automatically
            ->useLogName('student') // tag logs with "student"
            ->setDescriptionForEvent(fn(string $eventName) => "Student record has been {$eventName}");
    }
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
