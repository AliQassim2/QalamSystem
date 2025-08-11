<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StructureManager extends Model
{
    protected $table = 'structure_manager';
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
