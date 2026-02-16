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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('sku')->unique()->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('unit')->default('viên'); // viên, thùng, bộ, etc.
            
            // Technical specifications
            $table->string('material')->nullable(); // Porcelain, Ceramic, etc.
            $table->string('size')->nullable(); // 60x60, 80x80, etc.
            $table->string('surface_type')->nullable(); // Polished, Matt, Wood-like, Marble-like
            $table->string('water_absorption')->nullable();
            $table->string('hardness')->nullable();
            $table->string('glaze_technology')->nullable();
            
            // Features
            $table->text('features')->nullable(); // JSON or text
            $table->text('applications')->nullable(); // Where to use
            
            // 3D visualization
            $table->string('view_3d_url')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
