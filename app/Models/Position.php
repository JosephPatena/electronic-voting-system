<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Candidate;

class Position extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function candidates(){
    	return $this->hasMany(Candidate::class);
    }
}
