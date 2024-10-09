<?php

namespace App\Exports;

use App\Models\Pasien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PasienExport implements FromCollection,  WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pasien::all();
    }

    /**
    * @return array
    */

    public function headings(): array
    {
        return [
            'ID Data Base',
            'No. Rekam Medis',
            'Tanggal Kunjungan',
            'Nama',
            'Tanggal Lahir',
            'Umur',
            'Jenis Kelamin',
            'Kelurahan',
            'Kecamatan',
            'Kota',
            'Telepon',
            'Email',
            'Alamat Lengkap',
            'Catatan Admin',
            'Rujukan',
            'created_at',
            'updated_at',
        ];
    }
}
