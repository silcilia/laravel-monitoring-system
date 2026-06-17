<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'url',
        'service_type',
        'last_status',
        'last_status_code',
        'last_response_time',
        'last_checked',
        'last_down_reason',
        'last_down_detail',
        'uptime_percentage',
        'last_notified',
        'notification_cooldown_minutes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_checked' => 'datetime',
        'last_notified' => 'datetime',
        'last_response_time' => 'float',
        'uptime_percentage' => 'float',
        'notification_cooldown_minutes' => 'integer',
        'last_status_code' => 'integer',
    ];

    /**
     * Default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'last_status' => 'UNKNOWN',
        'notification_cooldown_minutes' => 30,
        'uptime_percentage' => 100.0,
    ];

    /**
     * Get all logs for this service.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get all contacts for this service.
     */
    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(
            Contact::class,
            'service_contacts',
            'service_id',
            'contact_id'
        )->withTimestamps();
    }

    /**
     * Get latest log for this service.
     */
    public function latestLog()
    {
        return $this->hasOne(Log::class)->latest('timestamp');
    }

    /**
     * Check if service needs notification (anti spam).
     */
    public function needsNotification(): bool
    {
        if (!$this->last_notified) {
            return true;
        }

        $cooldown = $this->notification_cooldown_minutes ?? 30;
        $cooldownMinutes = now()->diffInMinutes($this->last_notified);
        
        return $cooldownMinutes >= $cooldown;
    }

    /**
     * Check if service is degraded (slow response).
     */
    public function isDegraded(): bool
    {
        if (!$this->last_response_time) {
            return false;
        }
        return $this->last_response_time > 5.0; // More than 5 seconds is slow
    }

    /**
     * Get status badge class for UI.
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->last_status) {
            'UP' => 'status-up',
            'WARNING' => 'status-warning',
            'DOWN' => 'status-down',
            default => 'status-unknown',
        };
    }

    /**
     * Get status display text for UI.
     */
    public function getStatusText(): string
    {
        return match ($this->last_status) {
            'UP' => 'UP - Normal',
            'WARNING' => 'WARNING - Perlu Perhatian',
            'DOWN' => 'DOWN - Tidak Berfungsi',
            default => 'UNKNOWN',
        };
    }

    /**
     * Get uptime color based on percentage.
     */
    public function getUptimeColor(): string
    {
        $uptime = $this->uptime_percentage ?? 0;
        
        if ($uptime >= 90) {
            return '#10b981'; // green
        } elseif ($uptime >= 70) {
            return '#f59e0b'; // yellow/orange
        }
        return '#ef4444'; // red
    }

    /**
     * Scope a query to only include active services.
     */
    public function scopeActive($query)
    {
        return $query->where('last_status', '!=', 'UNKNOWN');
    }

    /**
     * Scope a query to filter by service type.
     */
    public function scopeType($query, $type)
    {
        return $query->where('service_type', $type);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('last_status', $status);
    }

    /**
     * Get readable down reason.
     */
    public function getReadableReason(): string
    {
        $reason = $this->last_down_reason;
        $detail = $this->last_down_detail;
        $statusCode = $this->last_status_code;
        $responseTime = $this->last_response_time;

        $reasonMap = [
            'REDIRECT' => '🔄 URL Redirect - Perlu update URL di database',
            'EMPTY_PAGE' => '📄 Halaman kosong - Cek aplikasi, mungkin error/maintenance',
            'SLOW_RESPONSE' => "🐌 Response lambat ({$responseTime}s) - Optimasi performa",
            'SSL_ERROR' => '🔒 SSL Certificate error - Perbarui sertifikat SSL',
            'TIMEOUT' => '⏱️ Request timeout - Server tidak merespon dalam batas waktu',
            'CONNECTION_REFUSED' => '🔌 Connection Refused - Server MATI atau port tertutup',
            'DNS_ERROR' => '🌐 DNS Error - Domain tidak dapat diresolve',
            'HTTP_401' => '🔐 401 Unauthorized - Memerlukan autentikasi login',
            'HTTP_403' => '🚫 403 Forbidden - Memerlukan izin akses',
            'HTTP_404' => '🔍 404 Not Found - Halaman/endpoint tidak ditemukan',
            'HTTP_429' => '🐌 429 Too Many Requests - Terlalu banyak request',
            'HTTP_500' => '💥 500 Internal Server Error - Cek log error server',
            'HTTP_502' => '⚙️ 502 Bad Gateway - Gateway error',
            'HTTP_503' => '⚙️ 503 Service Unavailable - Layanan sibuk',
            'HTTP_504' => '⏱️ 504 Gateway Timeout - Gateway timeout',
        ];

        if ($reason && isset($reasonMap[$reason])) {
            return $reasonMap[$reason];
        }

        if ($statusCode) {
            return "HTTP {$statusCode} - " . ($detail ?: 'Unknown error');
        }

        if ($detail) {
            return $detail;
        }

        return $reason ?? 'Unknown error';
    }

    /**
     * Get response time display.
     */
    public function getResponseTimeDisplay(): string
    {
        if (!$this->last_response_time) {
            return '-';
        }
        return number_format($this->last_response_time, 2) . 's';
    }

    /**
     * Get last checked display.
     */
    public function getLastCheckedDisplay(): string
    {
        if (!$this->last_checked) {
            return 'Belum dicek';
        }
        return $this->last_checked->format('d/m/Y H:i:s');
    }

    /**
     * Check if service is currently UP.
     */
    public function isUp(): bool
    {
        return $this->last_status === 'UP';
    }

    /**
     * Check if service is currently DOWN.
     */
    public function isDown(): bool
    {
        return $this->last_status === 'DOWN';
    }

    /**
     * Check if service is in WARNING state.
     */
    public function isWarning(): bool
    {
        return $this->last_status === 'WARNING';
    }

    /**
     * Get service type icon.
     */
    public function getTypeIcon(): string
    {
        return $this->service_type === 'HTTP' ? '🌐' : '📡';
    }

    /**
     * Get service type badge class.
     */
    public function getTypeBadgeClass(): string
    {
        return $this->service_type === 'HTTP' ? 'type-http' : 'type-ping';
    }
}