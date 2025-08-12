<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class School extends Model
{
    use HasRelationships;
    protected $guarded = [];

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }
    public function classes()
    {
        return $this->hasManyThrough(SchoolClass::class, Stage::class, 'school_id', 'stage_id', 'id', 'id');
    }
    public function subjects()
    {
        return $this->hasManyThrough(Subject::class, Stage::class, 'school_id', 'stage_id', 'id', 'id');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
    public function students()
    {
        return $this->hasManyDeep(
            Student::class,
            [Stage::class, SchoolClass::class], // intermediate models
            [
                'school_id', // Foreign key on stages table
                'stage_id',  // Foreign key on classes table
                'class_id'   // Foreign key on students table
            ],
            [
                'id', // Local key on schools table
                'id', // Local key on stages table
                'id'  // Local key on classes table
            ]
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
