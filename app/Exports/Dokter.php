<?php

namespace App\Exports;

use App\Models\DataDokter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Dokter implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        return DataDokter::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'Nama Dokter',
            'Created_at',
            'Updated_at'
        ];
    }
}
