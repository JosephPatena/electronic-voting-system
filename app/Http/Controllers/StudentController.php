<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Imports\StudentsKeyImport;
use App\Mail\StudentsInvitation;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Exception;
use Auth;

use App\Models\StudentsKey;
use App\Models\User;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = User::where('role_id', 3)
                        ->where('election_id', Auth::user()->election_id)
                        ->where('teacher_id', Auth::id())
                        ->simplePaginate(20);
        return view('teacher.student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $imported = StudentsKey::orderBy('user_id', 'asc')
                            ->where('election_id', Auth::user()->election_id)
                            ->where('teacher_id', Auth::id())
                            ->simplePaginate(20);
        return view('teacher.student.import', compact('imported'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $check = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xlx,xls,xlsx|max:2048'
        ]);

        if ($check->fails()) {
            return response()->json(['code' => 400, 'msg' => $check->messages()->first()]);
        }

        Excel::import(new StudentsKeyImport, $request->file('file')->store('temp'));
        return response()->json(['code' => 200, 'msg' => "File imported successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StudentsKey::destroy($id);

        toastr()->success("Key deleted successfully.");
        return redirect()->back();
    }

    public function invite_students($type)
    {
        if ($type == "not_register")
        {
            $keys = StudentsKey::whereNull('user_id')->get();
        }
        elseif ($type == "uninvited")
        {
            $keys = StudentsKey::whereNull('user_id')->where('is_invited', false)->get();
        }
        else
        {
            $keys = StudentsKey::where('id', $type)->get();
        }


        foreach ($keys as $key => $value) 
        {
            try
            {
                Mail::to($value->email)->send(new StudentsInvitation($value->key, $value->name));
                $value->is_invited = true;
                $value->save();
            } 
            catch (Exception $e) 
            {
                Log::info($e);
            }
        }

        toastr()->success("Invitation sent successfully.");
        return redirect()->back();
    }

    # Admin Functions

    public function students_list(){
        $students = User::where('role_id', 3)
                        ->where('election_id', Helper::get_active_election() ? Helper::get_active_election()->id : 0)
                        ->simplePaginate(20);
        return view('admin.student.index', compact('students'));
    }
}
