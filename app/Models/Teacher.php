<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Teacher extends Model
{
    use HasRelationships;

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
    public function stages()
    {
        return $this->hasManyDeep(
            Stage::class,       // Final model we want
            [Link::class, SchoolClass::class], // Intermediate models
            [
                'teacher_id',   // Foreign key on links table
                'stage_id',     // Foreign key on classes table
                'id'            // Foreign key on stages table (not needed, Laravel will assume)
            ],
            [
                'id',           // Local key on teacher table
                'class_id',     // Local key on links table
                'id'            // Local key on classes table
            ]
        )->distinct();       // To avoid duplicate stages if teacher has multiple links in same stage
    }
}
