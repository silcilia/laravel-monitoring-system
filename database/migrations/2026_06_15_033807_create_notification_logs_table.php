<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();

            $table->enum('channel', [
                'WHATSAPP',
                'EMAIL'
            ]);

            $table->string('notification_type');

            $table->string('recipient');

            $table->string('title');

            $table->text('message');

            $table->boolean('is_sent')
                ->default(true);

            $table->timestamp('sent_at')
                ->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};