<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KunjunganImport;

class KunjunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $path = database_path('seeds/files/FO - DATA SERVICE PASIEN New 2208.csv');
        Excel::import(new KunjunganImport, $path);

    }
}
