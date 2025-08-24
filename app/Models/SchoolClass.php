<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model
{

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'stage_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function links()
    {
        return $this->hasMany(Link::class, 'class_id');
    }
    public function subjects()
    {
        return $this->hasManyThrough(Subject::class, Link::class, 'class_id', 'id', 'id', 'subject_id');
    }
}
