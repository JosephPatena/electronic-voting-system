<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Imports\TeachersKeyImport;
use App\Mail\TeachersInvitation;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Exception;

use App\Models\TeachersKey;
use App\Models\User;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = User::where('role_id', 2)
                        ->where('election_id', Helper::get_active_election() ? Helper::get_active_election()->id : 0)
                        ->simplePaginate(20);
        return view('admin.teacher.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $imported = TeachersKey::orderBy('user_id', 'asc')
                            ->where('election_id', Helper::get_active_election() ? Helper::get_active_election()->id : 0)
                            ->simplePaginate(20);
        return view('admin.teacher.import', compact('imported'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty(Helper::get_active_election())) {
            return response()->json(['code' => 400, 'msg' => 'No election found']);
        }

        $check = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xlx,xls,xlsx|max:2048'
        ]);

        if ($check->fails()) {
            return response()->json(['code' => 400, 'msg' => $check->messages()->first()]);
        }

        Excel::import(new TeachersKeyImport, $request->file('file')->store('temp'));
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
        $teacher = User::find($id);
        return view('admin.teacher.manage', compact('teacher'));
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
        TeachersKey::destroy($id);

        toastr()->success("Key deleted successfully.");
        return redirect()->back();
    }

    public function invite_teachers($type)
    {
        if ($type == "not_register")
        {
            $keys = TeachersKey::whereNull('user_id')->get();
        }
        elseif ($type == "uninvited")
        {
            $keys = TeachersKey::whereNull('user_id')->where('is_invited', false)->get();
        }
        else
        {
            $keys = TeachersKey::where('id', $type)->get();
        }


        foreach ($keys as $key => $value) 
        {
            try
            {
                Mail::to($value->email)->send(new TeachersInvitation($value->key, $value->name));
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
}
