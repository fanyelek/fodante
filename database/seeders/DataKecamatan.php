<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KecamatanImport;

class DataKecamatan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $path = database_path('seeds/files/kecamatan.csv');
        Excel::import(new KecamatanImport, $path);

    }
}
