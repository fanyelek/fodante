<?php

namespace App\Imports;

use App\Models\Kota;
use Maatwebsite\Excel\Concerns\ToModel;

class KotaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Kota([
            'nama_kota' => $row[0],
        ]);
    }
}
