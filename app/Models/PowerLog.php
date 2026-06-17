<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PowerLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'voltage',
        'current',
        'power',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'voltage' => 'float',
        'current' => 'float',
        'power' => 'float',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function getVoltageStatus(): string
    {
        $voltage = $this->voltage;
        if ($voltage >= 210 && $voltage <= 230) {
            return 'normal';
        } elseif ($voltage < 210) {
            return 'low';
        }
        return 'high';
    }

    public function getVoltageStatusClass(): string
    {
        return match ($this->getVoltageStatus()) {
            'normal' => 'status-normal',
            'low' => 'status-low',
            'high' => 'status-high',
            default => '',
        };
    }

    public function getVoltageStatusText(): string
    {
        return match ($this->getVoltageStatus()) {
            'normal' => 'Normal',
            'low' => 'Low Voltage',
            'high' => 'High Voltage',
            default => 'Unknown',
        };
    }

    public function getDisplayTimestamp(): string
    {
        return $this->timestamp->format('H:i:s');
    }

    public function getDisplayDate(): string
    {
        return $this->timestamp->format('d/m/Y H:i:s');
    }
}