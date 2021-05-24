<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Session;
use Auth;

use App\Models\Election;
use App\Models\Position;
use App\Models\Degree;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elections = Election::simplePaginate(10);
        return view('admin.election.index', compact('elections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.election.create');
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
            'name' => ['required', 'max:255'],
            'description' => ['required'],
            'validity' => ['required'],
            'position_name' => ['required', 'array'],
            'number_elected' => ['required', 'array']
        ]);

        if ($check->fails()) {
            toastr()->error($check->messages()->first());
            return redirect()->back()->withInput();
        }

        $validity = explode("-", $request->validity);

        $new = Election::create([
            'name' => $request->name,
            'description' => $request->description,
            'date_start' => Carbon::parse($validity[0])->format('Y-m-d H:i:s'),
            'date_end' => Carbon::parse($validity[1])->format('Y-m-d H:i:s')
        ]);

        foreach ($request->position_name as $key => $value) {
            Position::create([
                'election_id' => $new->id,
                'name' => $value,
                'number_elected' => $request->number_elected[$key]
            ]);
        }

        toastr()->success("Election registered successfully.");
        return redirect()->route('elections.show', $new->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Election $election)
    {
        $degree = Degree::all();
        return view('admin.election.manage', compact('election', 'degree'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Election $election)
    {
        return view('admin.election.manage');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Election $election)
    {
        if (isset($request->validity))
        {
            $validity = explode("-", $request->validity);
            Arr::pull($request, 'validity');

            $request->request->add([
                'date_start' => Carbon::parse($validity[0])->format('Y-m-d H:i:s'),
                'date_end' => Carbon::parse($validity[1])->format('Y-m-d H:i:s')
            ]);
        }
        
        $election->update($request->all());

        toastr()->success("Election updated successfully.");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Election::destroy(decrypt($id));

        toastr()->success("Election deleted successfully.");
        return redirect()->back();
    }

    public function election_result(){
        if (Auth::user()->role_id == 1)
        {
            return view('admin.election.results');
        }
        if (Auth::user()->role_id == 2)
        {
            return view('teacher.election.results');
        }
        if (Auth::user()->role_id == 3)
        {
            return view('student.election.results');
        }
    }

    public function end_election($id){
        Election::find(decrypt($id))->update(['date_end' => Carbon::now()]);

        toastr()->success("Election ended successfully.");
        return redirect()->back();
    }

    public function navigate($id){
        Session::put(['election_id' => decrypt($id)]);

        toastr()->success("Success");
        return redirect()->back();
    }
}
