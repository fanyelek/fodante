<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nama_kecamatan',
    'kota_id'
    ];

    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class);
    }
}
