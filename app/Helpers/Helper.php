<?php

namespace App\Helpers;

use DB;
use Auth;
use Session;
use DateTime;

use Carbon\CarbonPeriod;

use App\Models\ELection;
use App\Models\Image;
use App\Models\User;

class Helper
{
	public static function generate_key($type){
		$unique = false;

        // Store tested results in array to not test them again
        $tested = [];

        do
        {
            $key;

	        // Generate random number
	        $key = Helper::generateRandomString(date("siHymd"));

	        // Check if it's already testing
	        // If so, don't query the database again
	        if( in_array($key, $tested) )
	        {
	            continue;
	        }

	        if ($type == "teachers")
	        {
            	$count = DB::table('teachers_keys')->where('key', $key)->count();
	        }

	        if ($type == "students")
	        {
            	$count = DB::table('students_keys')->where('key', $key)->count();
	        }
            
            // Store the random number in the tested array
            // To keep track which ones are already tested
            $tested[] = $key;

            // Code appears to be unique
            if($count == 0)
            {
                return $key;
            }

            // If unique is still false at this point
            // it will just repeat all the steps until
            // it has generated a random string of characters
        }
        while(!$unique);
	}

	public static function generateRandomString($num, $length = 70) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.$num, ceil($length/strlen($x)) )),1,$length);
	}

	public static function get_active_election(){
		if (Session::has('election_id')) {
			return ELection::find(Session::get('election_id'));
		}
		return ELection::latest()->first();
	}

	public static function find_election(){
		return ELection::find(Auth::user()->election_id);
	}

	public static function get_elections(){
		return ELection::latest()->get();
	}

	public static function get_user_image(){
		return Image::find(Auth::user()->image_id);
	}

	public static function students($teacher_id){
		return User::where('teacher_id', $teacher_id)->get();
	}

	public static function user($id){
		return User::find($id);
	}

	public static function get_hours($election){
		$period = CarbonPeriod::create("2020-5-20", "2020-5-30");
		foreach ($period as $date) {
		  // Insert Dates into listOfDates Array
		  $listOfDates[] = $date->format('h');
		}

		// Now You Can Review This Array
		dd($listOfDates);
	}
}