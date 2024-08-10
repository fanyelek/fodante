<?php

namespace App\Imports;

use App\Models\Kecamatan;
use App\Models\Kota;
use Maatwebsite\Excel\Concerns\ToModel;

class KecamatanImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $kota = Kota::where('nama_kota', $row[1])->first();

        return new Kecamatan([
            'nama_kecamatan' => $row[0],
            'kota_id' => $kota ? $kota->id : null,
        ]);
    }
}
