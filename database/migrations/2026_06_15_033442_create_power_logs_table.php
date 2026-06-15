<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('power_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('device_id')
                ->constrained('devices')
                ->cascadeOnDelete();

            $table->float('voltage');
            $table->float('current');
            $table->float('power');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('power_logs');
    }
};