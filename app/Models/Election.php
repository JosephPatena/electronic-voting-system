<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Candidate;
use App\Models\Position;
use App\Models\User;
use App\Models\Vote;

class Election extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function positions(){
    	return $this->hasMany(Position::class);
    }

    public function candidates(){
    	return $this->hasMany(Candidate::class);
    }

    public function votes(){
    	return $this->hasMany(Vote::class);
    }

    public function users(){
    	return $this->hasMany(User::class);
    }
}
