<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    use HasFactory;

    protected $keyType = 'string'; // Indicate that the primary key type is a string, not an integer.
    public $incrementing = false; // Disable auto-incrementing as we are using UUIDs.

    protected $fillable = [
        'name', 'email', 'phone', 'message', 'read_unread'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
        });
    }
}
