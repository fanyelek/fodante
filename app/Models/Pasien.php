<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $fillable = [
        'norm',
        // 'kunjungan',
        'tanggal',
        'nama',
        'gender',
        'lahir',
        'age',
        'kelurahan',
        'kecamatan',
        'kota',
        'fulladress',
        'telepon',
        'email',
        'adminNote',
        'rujukan',
    ];

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function detail_service_pasiens()
    {
        return $this->hasMany(DetailServicePasien::class);
    }
}
