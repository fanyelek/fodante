<?php

namespace App\Imports;

use App\Models\DataDokter;
use Maatwebsite\Excel\Concerns\ToModel;

class Dokter implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DataDokter([
            'nama_dokter' => $row[0]
        ]);
    }
}
