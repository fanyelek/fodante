<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailServicePasien extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['tanggal',
    'tarif',
    'diskon_klinik',
    'harga_bayar',
    'pasien_id',
    'dentist_id',
    'service_id',
    'catatan'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dentist()
    {
        return $this->belongsTo(DataDokter::class, 'dentist_id');
    }

    public function service()
    {
        return $this->belongsTo(DataService::class, 'service_id');
    }
}
