<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NameData extends Model
{
    protected $fillable = ['id', 'name', 'category_id'];

    public function provinceDatas(): HasMany
    {
        return $this->hasMany(ProvinceData::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function regencyDatas(): HasMany
    {
        return $this->hasMany(RegencyData::class);
    }
}
