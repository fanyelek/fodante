<?php

namespace App\Imports;

use App\Models\Pasien;
use App\Models\DetailServicePasien;
use App\Http\Controllers\PasienController;
use App\Helpers\FormatHelper;
use Maatwebsite\Excel\Concerns\ToModel;

class PasienImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (Pasien::exists()) {

            $dataTerakhir = Pasien::orderBy('id', 'desc')->first();
            $teks = $dataTerakhir->norm;

            // Contoh penggunaan
            $hasil = FormatHelper::pisahkan_huruf_angka($teks);
            
            $huruf = $hasil[1];
            $angka = $hasil[2];

            $jumlah_digit = 4; // Jumlah digit yang ingin dipertahankan

            $norm = FormatHelper::tambahAngkaDenganFormat($huruf, $angka, $jumlah_digit);

        } else {

            $norm = 'A'. '0001';

        }
        
        return new Pasien([
            'norm'     => $row[0],
            // 'tanggal'  => $row[1],
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
        ]);
    }
}
