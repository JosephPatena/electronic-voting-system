<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Helpers\Helper;
use App\Models\Image;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidates = Candidate::where('election_id', Helper::get_active_election() ? Helper::get_active_election()->id : 0)
                        ->simplePaginate(20);
        return view('admin.candidate.index', compact('candidates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'election_id' => ['required'],
            'position_id' => ['required'],
            'degree_id' => ['required'],
            'area_of_study' => ['required'],
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            'agenda' => ['required']
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

        Candidate::create([
            'election_id' => decrypt($request->election_id),
            'position_id' => $request->position_id,
            'name' => $request->name,
            'degree_id' => $request->degree_id,
            'area_of_study' => $request->area_of_study,
            'image_id' => $image->id,
            'agenda' => $request->agenda
        ]);

        toastr()->success("Candidate registered successfully.");
        return redirect()->back();
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
        //
    }
}
