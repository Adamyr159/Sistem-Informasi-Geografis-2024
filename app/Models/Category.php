<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['id', 'name'];

    public function nameDatas(): HasMany
    {
        return $this->hasMany(NameData::class);
    }
}
