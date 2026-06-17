<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'service_id',
        'status',
        'status_code',
        'response_time',
        'down_reason',
        'message',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'response_time' => 'float',
        'status_code' => 'integer',
    ];

    protected $attributes = [
        'status' => 'UNKNOWN',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'UP' => 'badge-success',
            'WARNING' => 'badge-warning',
            'DOWN' => 'badge-danger',
            default => 'badge-secondary',
        };
    }

    public function getStatusText(): string
    {
        return match ($this->status) {
            'UP' => '✅ UP - Normal',
            'WARNING' => '⚠️ WARNING - Perlu Perhatian',
            'DOWN' => '❌ DOWN - Tidak Berfungsi',
            default => '❓ UNKNOWN',
        };
    }
}