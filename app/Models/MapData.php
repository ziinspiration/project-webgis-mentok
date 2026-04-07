<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MapData extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['category_id', 'name', 'type', 'geojson_path', 'icon_path', 'sort_order'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id = (string) Str::uuid());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
