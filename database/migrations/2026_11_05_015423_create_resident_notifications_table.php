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
    Schema::create('resident_notifications', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->foreignId('request_id')
            ->nullable()
            ->constrained('requests')
            ->nullOnDelete();

        $table->string('title');
        $table->text('message');
        $table->string('type'); // status_update or claim_date
        $table->boolean('is_read')->default(false);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('resident_notifications');
}
};
