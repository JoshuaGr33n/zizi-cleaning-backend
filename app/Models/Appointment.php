<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
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

        static::saving(function ($appointment) {
            // Check if the status is being changed to "complete" or "canceled"
            if (in_array($appointment->status, ['complete', 'canceled']) && $appointment->isDirty('status')) {
                $appointment->status_updated_at = now();
            }
        });
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'flag',
        'reference_number',
        'company_name',
        'phone',
        'email',
        'address',
        'service_details',
        'availability',
        'extras',
        'extras_2',
        'additional_instructions',
        'image_paths',
        'status',
        'read',
    ];

    protected $casts = [
        'address' => 'array',
        'service_details' => 'array',
        'availability' => 'array',
        'extras' => 'array',
        'extras_2' => 'array',
        'image_paths' => 'array',
    ];

    public function getUpdatedByUserAttribute()
    {
        if (is_null($this->updated_by)) {
            return 'Client';
        }
        return $this->updatedBy->name ?? 'Unknown Admin';
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
