<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change bedroom space_type to kitchen
        DB::table('products')
            ->where('space_type', 'bedroom')
            ->update(['space_type' => 'kitchen']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change kitchen back to bedroom
        DB::table('products')
            ->where('space_type', 'kitchen')
            ->update(['space_type' => 'bedroom']);
    }
};
