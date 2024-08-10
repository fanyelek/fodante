<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataService extends Model
{
    use HasFactory;

    protected $fillable = ['service'];

    public function detailServices()
    {
        return $this->hasMany(DetailServicePasien::class);
    }
}
