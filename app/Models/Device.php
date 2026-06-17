<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'threshold_voltage',
        'threshold_current',
        'status',
        'last_seen',
        'has_power_backup',
        'wifi_ssid',
        'wifi_config_count',
    ];

    protected $casts = [
        'last_seen' => 'datetime',
        'has_power_backup' => 'boolean',
        'threshold_voltage' => 'float',
        'threshold_current' => 'float',
        'wifi_config_count' => 'integer',
    ];

    protected $attributes = [
        'status' => 'ONLINE',
        'has_power_backup' => false,
        'wifi_config_count' => 0,
        'threshold_voltage' => 210,
        'threshold_current' => 1.5,
    ];

    public function powerLogs(): HasMany
    {
        return $this->hasMany(PowerLog::class)->orderBy('timestamp', 'desc');
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(
            Contact::class,
            'device_contacts',
            'device_id',
            'contact_id'
        )->withTimestamps();
    }

    public function latestPowerLog()
    {
        return $this->hasOne(PowerLog::class)->latest('timestamp');
    }

    public function isOffline(): bool
    {
        if (!$this->last_seen) {
            return true;
        }
        return now()->diffInMinutes($this->last_seen) > 5;
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'ONLINE' => 'status-up',
            'DEGRADED' => 'status-warning',
            'OFFLINE' => 'status-down',
            default => 'status-unknown',
        };
    }

    public function getStatusText(): string
    {
        return match ($this->status) {
            'ONLINE' => 'ONLINE - Aktif',
            'DEGRADED' => 'DEGRADED - Perlu Perhatian',
            'OFFLINE' => 'OFFLINE - Mati',
            default => 'UNKNOWN',
        };
    }

    public function canChangeWifi(): bool
    {
        return ($this->wifi_config_count ?? 0) < 5;
    }

    public function getRemainingWifiChanges(): int
    {
        return max(0, 5 - ($this->wifi_config_count ?? 0));
    }

    public function getLastSeenDisplay(): string
    {
        if (!$this->last_seen) {
            return 'Tidak pernah';
        }
        return $this->last_seen->format('d/m/Y H:i:s');
    }

    public function getVoltageStatus(float $voltage): string
    {
        if ($voltage >= $this->threshold_voltage - 10 && $voltage <= $this->threshold_voltage + 20) {
            return 'normal';
        }
        if ($voltage < $this->threshold_voltage - 10) {
            return 'low';
        }
        return 'high';
    }
}