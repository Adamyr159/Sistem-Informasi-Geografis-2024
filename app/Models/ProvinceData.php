<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProvinceData extends Model
{
    protected $fillable = ['id', 'year', 'name_data_id', 'province_id', 'amount'];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function nameData(): BelongsTo
    {
        return $this->belongsTo(NameData::class);
    }
}
