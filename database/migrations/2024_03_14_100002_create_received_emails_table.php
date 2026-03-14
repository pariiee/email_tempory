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
        Schema::create('received_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('temp_email_id')->constrained('temp_emails')->onDelete('cascade');
            $table->string('sender_email');
            $table->string('sender_name')->nullable();
            $table->text('subject')->nullable();
            $table->longText('body_text')->nullable();
            $table->longText('body_html')->nullable();
            $table->timestamp('received_at');
            $table->boolean('is_read')->default(false);
            $table->string('message_id')->nullable()->unique();
            $table->longText('raw_email')->nullable();
            $table->timestamps();
            
            $table->index(['temp_email_id', 'received_at']);
            $table->index(['temp_email_id', 'is_read']);
            $table->index('sender_email');
            $table->index('received_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('received_emails');
    }
};