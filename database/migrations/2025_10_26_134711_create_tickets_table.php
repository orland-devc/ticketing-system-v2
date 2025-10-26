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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->nullable()->unique();
            $table->string('sender_id')->constrained('users')->onDelete('cascade');
            $table->string('assigned_to')->nullable()->constrained('users');
            $table->string('level');
            $table->string('subject');
            $table->string('category');
            $table->text('content')->nullable();
            $table->string('status')->default('sent');

            $table->string('guest_name')->nullable();
            $table->date('guest_birthdate')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_tracking_token')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
