<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MapData extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['category_id', 'user_id', 'name', 'type', 'geojson_path', 'icon_path', 'sort_order'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id = 'map-' . Str::random(32));
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
