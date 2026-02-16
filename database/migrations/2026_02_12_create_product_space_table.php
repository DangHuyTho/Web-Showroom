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
        Schema::create('product_space', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('space_type'); // living_room, kitchen, bathroom, outdoor
            $table->timestamps();
            
            $table->unique(['product_id', 'space_type']);
        });

        // Drop the old space_type column from products
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('space_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_space');
        
        Schema::table('products', function (Blueprint $table) {
            $table->string('space_type')->nullable()->after('surface_type');
        });
    }
};
