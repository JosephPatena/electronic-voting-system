<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BallotController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CandidateController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Redirect homepage
|--------------------------------------------------------------------------
*/
Route::get('/', function(){
	if (Auth::check() && Auth::user()->role_id == 1)
	{
		return redirect()->route('admin_homepage');
	}
	else if (Auth::check() && Auth::user()->role_id == 2)
	{
		return redirect()->route('teacher_homepage');
	}
	else if (Auth::check() && Auth::user()->role_id == 3)
	{
		return redirect()->route('student_homepage');
	}
	return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Guest routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'guest'], function(){
	Route::get('login', [AuthController::class, 'login'])->name('login');
	Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

	# Teacher
	Route::get('teachers-registration/{key}', [AuthController::class, 'teachers_registration'])->name('teachers_registration');
	Route::post('register-teacher', [AuthController::class, 'register_teacher'])->name('register_teacher');

	# Voter
	Route::get('students-registration/{key}', [AuthController::class, 'students_registration'])->name('students_registration');
	Route::post('register-student', [AuthController::class, 'register_student'])->name('register_student');
});

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function(){
	Route::get('logout', [AuthController::class, 'logout'])->name('logout');

	# Election
	Route::get('election-result', [ElectionController::class, 'election_result'])->name('election_result');
	Route::post('count-ballot/{position_id}', [BallotController::class, 'count_ballot'])->name('count_ballot');

	# Authorize
	Route::post('check-password', [AuthController::class, 'check_password'])->name('check_password');
});

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['admin', 'auth']], function(){
	# Homepage
	Route::get('admin/homepage', [HomepageController::class, 'admin_homepage'])->name('admin_homepage');

	# Election
	Route::resource('elections', ElectionController::class);
	Route::get('end-election/{id}', [ElectionController::class, 'end_election'])->name('end_election');
	Route::get('navigate/{id}', [ElectionController::class, 'navigate'])->name('navigate');

	# Position
	Route::resource('positions', PositionController::class);

	# Candidate
	Route::resource('candidates', CandidateController::class);

	# Teacher
	Route::resource('teachers', TeacherController::class);
	Route::get('invite-teachers/{type}', [TeacherController::class, 'invite_teachers'])->name('invite_teachers');

	# Student
	Route::get('students-list', [StudentController::class, 'students_list'])->name('students_list');

	# Course
	Route::resource('courses', CourseController::class);
});

/*
|--------------------------------------------------------------------------
| Teacher routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['teacher', 'auth']], function(){
	# Homepage
	Route::get('teacher/homepage', [HomepageController::class, 'teacher_homepage'])->name('teacher_homepage');

	# Voter
	Route::resource('students', StudentController::class);
	Route::get('invite-studens/{type}', [StudentController::class, 'invite_students'])->name('invite_students');
});

/*
|--------------------------------------------------------------------------
| Student routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['student', 'auth']], function(){
	# Homepage
	Route::get('student/homepage', [HomepageController::class, 'student_homepage'])->name('student_homepage');

	# Cast Ballot
	Route::resource('ballot', BallotController::class);
});

/*
|--------------------------------------------------------------------------
| Unauthorized
|--------------------------------------------------------------------------
*/
Route::get('unauthorized', function(){
	if (Auth::user()->role_id == 1)
	{
		return view('admin.401');
	}
	if (Auth::user()->role_id == 2)
	{
		return view('teacher.401');
	}
	if (Auth::user()->role_id == 3)
	{
		return view('student.401');
	}
})->name('unauthorized');