<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ServiceImport;

class DataService extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $path = database_path('seeds/files/Data Service.csv');
        Excel::import(new ServiceImport, $path);

    }
}
