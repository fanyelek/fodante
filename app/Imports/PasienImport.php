<?php

namespace App\Imports;

use App\Models\Pasien;
use App\Models\DetailServicePasien;
use App\Http\Controllers\PasienController;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class PasienImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
                
        return new Pasien([
            'norm'     => $row[1],
            'tanggal'  => $row[2],
            'nama'     => $row[3],
            'lahir'    => $row[4],
            'age'      => $row[5],
            'gender'      => $row[6],
            'kelurahan'    => $row[7],
            'kecamatan'   => $row[8],
            'kota'   => $row[9],
            'telepon'   => $row[10],
            'email'  => $row[11],
            'fulladdress'    => $row[12],
            'adminNote'  => $row[13],
            'rujukan'  => $row[14],
            'created_at' => $row[15],
            'updated_at' => $row[16],
        ]);
    }
}
