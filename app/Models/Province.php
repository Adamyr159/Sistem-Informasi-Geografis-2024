<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = ['id', 'name', 'alt_name', 'latitude', 'longitude', 'geojson_path'];

    // public function regency(): HasMany{
    //     return $this->hasMany(Regency::class);
    // }

    public function provinceDatas(): HasMany
    {
        return $this->hasMany(ProvinceData::class);
    }

    public function regencies(): HasMany
    {
        return $this->hasMany(Regency::class);
    }
}
