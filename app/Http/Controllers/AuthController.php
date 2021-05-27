<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;

use App\Models\TeachersKey;
use App\Models\StudentsKey;
use App\Models\Degree;
use App\Models\Image;
use App\Models\User;

class AuthController extends Controller
{
    public function login(){
    	return view('auth.login');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function authenticate(Request $request){
    	$remember_me = isset($request->remember_me) ? true : false;
    	$credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $remember_me)) {
            $request->session()->regenerate();

            toastr()->success("Hi " . Auth::user()->first_name . ", Welcome back!");
            return redirect()->back();
        }

        toastr()->error("Failed!", "The provided credentials do not match our records.");
        return redirect()->back()->with(['error' => "The provided credentials do not match our records."])->withInput();
    }

    public function teachers_registration($key){
        return view('auth.teachers_registration', compact('key'));
    }

    public function register_teacher(Request $request){
        $if_exist = TeachersKey::where('key', decrypt($request->key))->first();
        if (empty($if_exist)) {
            toastr()->error("The link doesn't exist or expired.");
            return redirect()->back()->withInput();
        }

        if (!empty($if_exist->user_id)) {
            toastr()->error("Whoops! You can only use the link once. Seems like you already register the key associated with this link. Please Login instead.");
            return redirect()->back()->withInput();
        }

        $validate = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'alpha_dash'],
            'confirm_password' => ['required', 'same:password'],
            'key' => ['required'],
        ]);

        if ($validate->fails()) {
            toastr()->error($validate->messages()->first());
            return redirect()->back()->withInput();
        }

        $new = User::create([
            'role_id' => 2,
            'election_id' => $if_exist->election_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $if_exist->update(['user_id' => $new->id]);

        toastr()->success("Registered successfully. Please Login");
        return redirect()->route('login');
    }

    public function students_registration($key){
        $degree = Degree::all();
        return view('auth.students_registration', compact('key', 'degree'));
    }

    public function register_student(Request $request){
        $if_exist = StudentsKey::where('key', decrypt($request->key))->first();
        if (empty($if_exist)) {
            toastr()->error("The link doesn't exist or expired.");
            return redirect()->back()->withInput();
        }

        if (!empty($if_exist->user_id)) {
            toastr()->error("Whoops! You can only use the link once. Seems like you already register the key associated with this link. Please Login instead.");
            return redirect()->back()->withInput();
        }

        $validate = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'alpha_dash'],
            'confirm_password' => ['required', 'same:password'],
            'degree_id' => ['required'],
            'area_of_study' => ['required'],
            'key' => ['required'],
        ]);

        if ($validate->fails()) {
            toastr()->error($validate->messages()->first());
            return redirect()->back()->withInput();
        }

        $new = User::create([
            'role_id' => 3,
            'election_id' => $if_exist->election_id,
            'teacher_id' => $if_exist->teacher_id,
            'degree_id' => $request->degree_id,
            'area_of_study' => $request->area_of_study,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $if_exist->update(['user_id' => $new->id]);

        toastr()->success("Registered successfully. Please Login");
        return redirect()->route('login');
    }

    public function check_password(Request $request){
        if(Hash::check($request->password, Auth::user()->password)){
            return response()->json(true);    
        }
        return response()->json(false);
    }

    public function profile(){
        if (Auth::user()->role_id == 1)
        {
            return view('admin.profile.index');
        }
        if (Auth::user()->role_id == 2)
        {
            return view('teacher.profile.index');
        }
        if (Auth::user()->role_id == 3)
        {
            return view('student.profile.index');
        }
    }

    public function update_profile(Request $request, $id){
        $email_validation = array('required', 'string', 'max:255', 'unique:users');
        if (Auth::user()->email == $request->email)
        {
            $email_validation = array_diff($email_validation, array('unique:users'));
        }

        $validate = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'email' => $email_validation
        ]);

        if ($validate->fails()) {
            toastr()->error($validate->messages()->first());
            return redirect()->back()->withInput();
        }

        User::findOrFail(decrypt($id))->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        if(isset($request->change_pass)){
            $validate = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'alpha_dash'],
                'confirm_password' => ['required', 'same:password']
            ]);

            if ($validate->fails()) {
                toastr()->error($validate->messages()->first());
                return redirect()->back()->withInput();
            }

            User::findOrFail(decrypt($id))->update([
                'password' => Hash::make($request->password)
            ]);
        }

        if (!empty($request->image)) {
            $check = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
            ]);

            if ($check->fails()) {
                toastr()->error($check->messages()->first());
                return redirect()->back()->withInput();
            }

            // This will store the image
            $request->image->store('public/image');
            // This will get the new name
            $hash_name = $request->image->hashName();

            $image = Image::create(['hash_name' => $hash_name]);

            User::findOrFail(decrypt($id))->update([
                'image_id' => $image->id
            ]);
        }

        toastr()->success("Profile updated successfully");
        return redirect()->back();
    }

    public function enable_disable_access($id){
        if (User::findOrFail(decrypt($id))->restricted) {
            User::findOrFail(decrypt($id))->update(['restricted' => false]);
            toastr()->success("User access enabled successfully");
        }else{
            User::findOrFail(decrypt($id))->update(['restricted' => true]);
            toastr()->success("User access disabled successfully");
        }

        return redirect()->back();
    }
}
