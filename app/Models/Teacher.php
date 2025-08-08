<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

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

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
