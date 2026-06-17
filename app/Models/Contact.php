<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'notification_channel',
        'is_active',
        'created_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
    ];

    protected $attributes = [
        'notification_channel' => 'WHATSAPP',
        'is_active' => true,
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'service_contacts',
            'contact_id',
            'service_id'
        )->withTimestamps();
    }

    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(
            Device::class,
            'device_contacts',
            'contact_id',
            'device_id'
        )->withTimestamps();
    }

    public function isWhatsAppChannel(): bool
    {
        return in_array($this->notification_channel, ['WHATSAPP', 'BOTH']);
    }

    public function isEmailChannel(): bool
    {
        return in_array($this->notification_channel, ['EMAIL', 'BOTH']);
    }

    public function getNotificationChannelDisplay(): string
    {
        return match ($this->notification_channel) {
            'WHATSAPP' => 'WhatsApp',
            'EMAIL' => 'Email',
            'BOTH' => 'WhatsApp & Email',
            default => 'Tidak Diketahui',
        };
    }

    public function getPhoneNumberFormatted(): string
    {
        $phone = $this->phone_number;
        if (empty($phone)) {
            return '-';
        }
        
        // Format: +62 xxx-xxxx-xxxx
        $cleaned = preg_replace('/\D/', '', $phone);
        if (substr($cleaned, 0, 1) === '0') {
            $cleaned = '62' . substr($cleaned, 1);
        }
        
        if (strlen($cleaned) >= 8) {
            if (strlen($cleaned) <= 10) {
                return '+' . substr($cleaned, 0, 4) . '-' . substr($cleaned, 4);
            }
            return '+' . substr($cleaned, 0, 4) . '-' . substr($cleaned, 4, 4) . '-' . substr($cleaned, 8);
        }
        
        return $phone;
    }
}