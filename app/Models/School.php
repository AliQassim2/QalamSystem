<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'logo_path',
        'address',
        'type',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
