<?php

namespace App\Imports;

use App\Helpers\Helper;
use App\Models\TeachersKey;
use Maatwebsite\Excel\Concerns\ToModel;

class TeachersKeyImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TeachersKey([
            'election_id' => Helper::get_active_election()->id,
            'key'         => Helper::generate_key('teachers'),
            'name'        => $row[0],
            'email'       => $row[1],
        ]);
    }
}
