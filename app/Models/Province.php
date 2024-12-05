<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = ['id', 'name', 'alt_name', 'latitude', 'longitude'];

    // public function regency(): HasMany{
    //     return $this->hasMany(Regency::class);
    // }
}
