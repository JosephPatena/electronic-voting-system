<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\TeachersKey;
use App\Models\StudentsKey;
use App\Models\Degree;
use App\Models\Image;
use App\Models\Vote;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'election_id',
        'image_id',
        'teacher_id',
        'degree_id',
        'area_of_study',
        'name',
        'email',
        'password',
        'restricted'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function teachers_key(){
        return $this->hasOne(TeachersKey::class);
    }

    public function students_key(){
        return $this->hasOne(StudentsKey::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }

    public function degree(){
        return $this->belongsTo(Degree::class);
    }

    public function image(){
        return $this->belongsTo(Image::class);
    }
}
