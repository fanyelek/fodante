<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $fillable = [
        'norm',
        'kunjungan',
        'nama',
        'lahir',
        'age',
        'kelurahan',
        'kecamatan',
        'kota',
        'telepon',
        'email',
        'adminNote',
        'rujukan',
    ];

    public function detail_service_pasiens()
    {
        return $this->hasMany(DetailServicePasien::class);
    }
}
