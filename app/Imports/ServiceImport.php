<?php

namespace App\Imports;

use App\Models\DataService;
use Maatwebsite\Excel\Concerns\ToModel;

class ServiceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DataService([
            'service' => $row[0]
        ]);
    }
}
