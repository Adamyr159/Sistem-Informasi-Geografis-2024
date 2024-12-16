<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegencyData extends Model
{
    protected $fillable = ['id', 'year', 'name_data_id', 'regency_id', 'amount'];

    public function nameData(): BelongsTo
    {
        return $this->belongsTo(NameData::class);
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }
}
