<?php

namespace App\Imports;

use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Kecamatan;
use Maatwebsite\Excel\Concerns\ToModel;

class KelurahanImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Mencari Kota berdasarkan nama
        $kota = Kota::where('nama_kota', $row[2])->first();

        // Jika kota tidak ditemukan, buat kota baru
        if (!$kota) {
            $kota = Kota::create([
                'nama_kota' => $row[2],
            ]);
            $kota = Kota::where('nama_kota', $row[2])->first();
        }

        // Mencari Kecamatan berdasarkan nama dan kota_id
        $kecamatan = Kecamatan::where('nama_kecamatan', $row[1])
            ->where('kota_id', $kota->id)
            ->first();

        // Jika kecamatan tidak ditemukan, buat kecamatan baru
        if (!$kecamatan) {
            $kecamatan = Kecamatan::create([
                'nama_kecamatan' => $row[1],
                'kota_id' => $kota->id,
            ]);
        }

        // Mengembalikan Kelurahan baru atau memperbarui yang ada
        return Kelurahan::updateOrCreate(
            [
                'nama_kelurahan' => $row[0],
                'kecamatan_id' => $kecamatan->id,
                'kota_id' => $kota->id,
            ],
        );
    }
}
