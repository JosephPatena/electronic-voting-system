<?php

namespace App\Imports;

use Auth;
use App\Helpers\Helper;
use App\Models\StudentsKey;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsKeyImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new StudentsKey([
            'election_id' => Auth::user()->election_id,
            'teacher_id'  => Auth::id(),
            'key'         => Helper::generate_key('students'),
            'name'        => $row[0],
            'email'       => $row[1],
        ]);
    }
}
