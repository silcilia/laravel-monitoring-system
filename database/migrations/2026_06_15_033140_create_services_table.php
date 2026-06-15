<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // Informasi service
            $table->string('name');
            $table->string('url');
            $table->enum('service_type', [
                'HTTP',
                'PING'
            ]);

            // Status terakhir
            $table->enum('last_status', [
                'UP',
                'DOWN',
                'DEGRADED',
                'UNKNOWN'
            ])->default('UNKNOWN');

            // Waktu terakhir dicek
            $table->timestamp('last_checked')->nullable();

            // Informasi jika down
            $table->string('last_down_reason')->nullable();
            $table->string('last_down_detail', 500)->nullable();

            // Status code HTTP
            $table->integer('last_status_code')->nullable();

            // Waktu respon (detik)
            $table->float('last_response_time')->nullable();

            // Anti spam notifikasi
            $table->timestamp('last_notified')->nullable();

            // Cooldown notifikasi (menit)
            $table->integer('notification_cooldown_minutes')
                  ->default(30);

            // Persentase uptime
            $table->float('uptime_percentage')
                  ->default(100);

            // created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};