<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
public function up(): void
{
    if (!Schema::hasColumn('users', 'contact_number')) {
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_number')->nullable();
        });
    }

    if (!Schema::hasColumn('users', 'verification_status')) {
        Schema::table('users', function (Blueprint $table) {
            $table->string('verification_status')
                ->default('Pending');
        });
    }
}

public function down(): void
{
    if (
        Schema::hasColumn('users', 'contact_number') ||
        Schema::hasColumn('users', 'verification_status')
    ) {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('users', 'contact_number')) {
                $columns[] = 'contact_number';
            }

            if (Schema::hasColumn('users', 'verification_status')) {
                $columns[] = 'verification_status';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
}
};
