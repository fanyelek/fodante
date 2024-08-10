<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDokter extends Model
{
    use HasFactory;

    protected $fillable = ['nama_dokter'
    ];
    
    public function detailServices()
    {
        return $this->hasMany(DetailServicePasien::class);
    }
}
