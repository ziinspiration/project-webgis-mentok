<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['user_name', 'action', 'subject', 'type'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id = 'act-' . Str::random(32));
    }
}
