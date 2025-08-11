<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    //Role of users
    public const ROLES = [
        'ادمن',
        'مدير',
        'مسؤول ادارة الحسابات',
        'مسؤول ادارة المدرسة',
        'معلم',
        'طالب',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function creator()
    {
        // Assuming 'created_by' is the foreign key in users table
        return $this->belongsTo(User::class, 'created_by');
    }
    // In App\Models\User.php
    public function schoolManager()
    {
        return $this->hasOne(\App\Models\SchoolManager::class, 'user_id');
    }

    public function userAdministrator()
    {
        return $this->hasOne(\App\Models\UserAdministrator::class, 'user_id');
    }

    public function structureManager()
    {
        return $this->hasOne(\App\Models\StructureManager::class, 'user_id');
    }

    public function teacher()
    {
        return $this->hasOne(\App\Models\Teacher::class, 'user_id');
    }

    public function student()
    {
        return $this->hasOne(\App\Models\Student::class, 'user_id');
    }
}
