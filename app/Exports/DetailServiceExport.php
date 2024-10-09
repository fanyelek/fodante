<?php

namespace App\Exports;

use App\Models\DetailServicePasien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailServiceExport implements FromCollection,  WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DetailServicePasien::with(['pasien', 'dentist', 'service'])->get()->map(function ($detail) {
            return [
                'Tanggal' => $detail->tanggal,
                'Pasien' => $detail->pasien->nama,
                'Service' => $detail->service->service,
                'Dokter' => $detail->dentist->nama_dokter,
                'Tarif' => $detail->tarif,
                'Diskon Klinik' => $detail->diskon_klinik,
                'Harga Bayar' => $detail->harga_bayar,
                'Catatan' => $detail->catatan,
            ];
        });
    }
    
    /**
    * @return array
    */

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama',
            'Dokter',
            'Layanan',
            'Tarif',
            'Diskon Klinik',
            'Harga Bayar',
            'Catatan',
        ];
    }
}
