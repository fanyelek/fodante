<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kota extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nama_kota'];

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class);
    }
}
