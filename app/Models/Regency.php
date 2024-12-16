<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Regency extends Model
{
    protected $fillable = ['id', 'province_id', 'name', 'alt_name', 'latitude', 'longitude'];

    public function province (): BelongsTo {
        return $this->belongsTo(Province::class);
    }

    public function regencyDatas (): HasMany {
        return $this->hasMany(RegencyData::class);
    }
}
