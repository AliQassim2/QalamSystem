<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
{


    protected $fillable = [
        'name',
        'school_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'stage_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
