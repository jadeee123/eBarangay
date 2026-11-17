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
        Schema::create('barangay_information', function (Blueprint $table) {
            $table->id();
            $table->string('barangay_name');
            $table->string('contact_email')->nullable();
            $table->string('contact_number', 30)->nullable();
            $table->string('office_hours')->nullable();
            $table->text('claim_instructions')->nullable();
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangay_information');
    }
};
