<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataService extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = ['service'];

    public function detailServices()
    {
        return $this->hasMany(DetailServicePasien::class);
    }
}
