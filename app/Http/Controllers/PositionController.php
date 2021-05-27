<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\Position;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'number_elected' => ['required'],
            'max_selected' => ['required']
        ]);

        if ($check->fails()) {
            toastr()->error($check->messages()->first());
            return redirect()->back()->withInput();
        }

        Position::create([
            'election_id' => decrypt($request->election_id),
            'name' => $request->name,
            'number_elected' => $request->number_elected,
            'max_selected' => $request->max_selected
        ]);

        toastr()->success("Position registered successfully.");
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
    public function update(Request $request, Position $position)
    {
        $check = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'number_elected' => ['required'],
            'max_selected' => ['required']
        ]);

        if ($check->fails()) {
            toastr()->error($check->messages()->first());
            return redirect()->back()->withInput();
        }

        $position->update([
            'name' => $request->name,
            'number_elected' => $request->number_elected,
            'max_selected' => $request->max_selected
        ]);

        toastr()->success("Position updated successfully.");
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
        //
    }
}
