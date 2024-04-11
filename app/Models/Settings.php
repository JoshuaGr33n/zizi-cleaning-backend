<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Settings extends Model
{
    use HasFactory;


    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }


    protected $fillable = [
        'name',
        'url',
        'image',
        'tag',
        'desc',
        'value',
        'category',
        'created_at',
        'updated_at',
    ];
}
