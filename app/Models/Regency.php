<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Regency extends Model
{
    protected $fillable = ['id', 'province_id', 'name', 'alt_name', 'latitude', 'longitude'];

    public function province (): BelongsTo {
        return $this->belongsTo(Province::class);
    }
}
