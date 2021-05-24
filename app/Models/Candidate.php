<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Position;
use App\Models\Degree;
use App\Models\Image;
use App\Models\Vote;

class Candidate extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function position(){
    	return $this->belongsTo(Position::class, 'position_id');
    }

    public function degree(){
    	return $this->belongsTo(Degree::class, 'degree_id');
    }

    public function image(){
    	return $this->belongsTo(Image::class, 'image_id');
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }
}
