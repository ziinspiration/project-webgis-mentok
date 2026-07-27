<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['user_id', 'name', 'sort_order'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id = 'cat-' . Str::random(32));
    }

    public function mapData()
    {
        return $this->hasMany(MapData::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
