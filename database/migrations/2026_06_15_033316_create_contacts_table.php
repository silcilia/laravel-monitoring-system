<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('phone_number');
            $table->string('email')->nullable();

            $table->enum('notification_channel', [
                'WHATSAPP',
                'EMAIL',
                'BOTH'
            ])->default('WHATSAPP');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};