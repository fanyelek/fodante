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
            'norm'     => $row[0],
            'tanggal'  => $row[1],
            // 'kunjungan'  => $row[2],
            'nama'     => $row[3],
            'lahir'    => $row[4],
            'age'      => $row[5],
            'gender'      => $row[6],
            'fulladress'    => $row[7],
            'kelurahan'   => $row[8],
            'kecamatan'   => $row[9],
            'kota'   => $row[10],
            'telepon'  => $row[11],
            'email'    => $row[12],
            'adminNote'  => $row[13],
            'rujukan'  => $row[14],
            'created_at' => Carbon::createFromFormat('Y/m/d', $row[1])->format('Y-m-d H:i:s'),
        ]);
    }
}
