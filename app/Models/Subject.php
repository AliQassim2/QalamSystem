<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

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

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
