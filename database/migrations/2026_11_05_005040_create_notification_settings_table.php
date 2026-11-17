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
        Schema::create('notification_settings', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
          ->unique()
          ->constrained('users')
          ->cascadeOnDelete();

    $table->boolean('request_updates')->default(true);
    $table->boolean('claim_reminders')->default(true);
    $table->boolean('account_notifications')->default(true);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
