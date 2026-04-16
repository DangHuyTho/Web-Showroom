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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'staff', 'admin'])->default('user')->after('username');
            $table->string('google_id')->nullable()->after('role');
            $table->string('google_token')->nullable()->after('google_id');
            $table->boolean('is_active')->default(true)->after('google_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'google_id', 'google_token', 'is_active']);
        });
    }
};
