<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KelurahanImport;

class DataKelurahan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $path = database_path('seeds/files/kelurahan.csv');
        Excel::import(new KelurahanImport, $path);
    }
}
