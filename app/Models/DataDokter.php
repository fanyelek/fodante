<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataDokter extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = ['nama_dokter'
    ];
    
    public function detailServices()
    {
        return $this->hasMany(DetailServicePasien::class);
    }
}
