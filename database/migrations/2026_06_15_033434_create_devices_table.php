<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('location');

            $table->float('threshold_voltage');
            $table->float('threshold_current');

            $table->enum('status', [
                'ONLINE',
                'OFFLINE',
                'DEGRADED'
            ])->default('ONLINE');

            $table->timestamp('last_seen')
                ->nullable();

            $table->boolean('has_power_backup')
                ->default(false);

            $table->string('wifi_ssid')
                ->nullable();

            $table->integer('wifi_config_count')
                ->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};