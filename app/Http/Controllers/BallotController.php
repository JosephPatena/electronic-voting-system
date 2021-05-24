<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\Vote;
use Carbon\Carbon;
use Auth;

class BallotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.cast.ballot');
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
        $election = Election::find(Auth::user()->election_id);

        if (Carbon::now()->format('Y-m-d H:i:s') < $election->date_start) {
            toastr()->error("Election hasn't started yet");
            return redirect()->back();
        }

        if (Carbon::now()->format('Y-m-d H:i:s') > $election->date_end) {
            toastr()->error("Election was ended");
            return redirect()->back();
        }

        if (!isset($request->candidates)) {
            toastr()->error("You do not select any candidate");
            return redirect()->back();
        }

        if (!empty(Vote::where('election_id', Auth::user()->election_id)->first())) {
            toastr()->error("You can only vote once");
            return redirect()->back();
        }
        
        foreach ($request->candidates as $key => $candidate_id) {

            $candidate = Candidate::find(decrypt($candidate_id));
            Vote::create([
                'user_id' => Auth::id(),
                'election_id' => $candidate->election_id,
                'position_id' => $candidate->position_id,
                'candidate_id' => $candidate->id
            ]);
        }

        toastr()->success("Ballot recorded successfully");
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

    public function count_ballot($position_id){
        $counted = array();

        foreach (Position::find(decrypt($position_id))->candidates as $key => $candidate) {

            array_push($counted, [
                $candidate->name,
                count($candidate->votes),
                !empty($candidate->image->hash_name) ? url('storage/image/'. $candidate->image->hash_name) : asset('dist/img/default-candidate.png')
            ]);
        }

        $sorted = $this->bubbleSort($counted);
        $result = array_reverse($sorted);

        return response()->json($result);
    }

    public function bubbleSort($arr)
    {
        $n = sizeof($arr);
     
        // Traverse through all array elements
        for($i = 0; $i < $n; $i++)
        {
            // Last i elements are already in place
            for ($j = 0; $j < $n - $i - 1; $j++)
            {
                // traverse the array from 0 to n-i-1
                // Swap if the element found is greater
                // than the next element
                if ($arr[$j][1] > $arr[$j+1][1])
                {
                    $t = $arr[$j];
                    $arr[$j] = $arr[$j+1];
                    $arr[$j+1] = $t;
                }
            }
        }

        return $arr;
    }
}
