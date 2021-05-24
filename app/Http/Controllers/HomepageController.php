<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;
use Auth;

class HomepageController extends Controller
{
    public function admin_homepage(){
    	return view('admin.homepage');
    }

    public function teacher_homepage(){
    	return view('teacher.homepage');
    }

    public function student_homepage(){
    	return view('student.homepage');
    }
}
