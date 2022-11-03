<?php

namespace App\Imports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportUsers implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Company([
            'name' => $row[1],
            'email' => $row[2],
            'address' => $row[3],
            // 'created_at'=>row[4],
        ]);
    }
}
