<?php

namespace App\Models;

use App\Enums\EstateTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Estate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'title_ar',
        'content_ar',
        'short',
        'short_ar',
        'keywords',
        'keywords_ar',
        'slug',
        'town_id',
        'image',
        'type',
        'min',
        'max',
    ];

    protected $casts = [
        'type' => EstateTypeEnum::class,
        'image' => 'array',
    ];

    public function town(): BelongsTo
    {
        return $this->belongsTo(CityTown::class, 'town_id');
    }

    public function city(): HasOneThrough
    {
        return $this->hasOneThrough(City::class, CityTown::class, 'id', 'id', 'town_id', 'city_id');
    }
}
