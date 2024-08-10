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
            'Jumlah Kunjungan',
            'Tanggal Kunjungan',
            'Nama',
            'Tanggal Lahir',
            'Age',
            'Alamat',
            'No. Telepon',
            'Email',
            'Service',
            'Biaya',
            'Catatan Admin',
            'Rujukan',
            'Data Created_at',
            'Data Update_at'
        ];
    }
}
