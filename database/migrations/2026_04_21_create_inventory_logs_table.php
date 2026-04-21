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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->comment('Nhân viên thực hiện thao tác');
            $table->integer('quantity_changed')->comment('Số lượng thay đổi (dương = nhập, âm = xuất)');
            $table->enum('action_type', ['stock_in', 'stock_out', 'adjustment', 'damage', 'return', 'sale', 'confirm'])->comment('Loại thao tác');
            $table->string('reference_id')->nullable()->comment('Tham chiếu (Order ID, Invoice ID, ...)');
            $table->text('notes')->nullable();
            $table->integer('quantity_before')->comment('Số lượng trước thao tác');
            $table->integer('quantity_after')->comment('Số lượng sau thao tác');
            $table->timestamps();

            // Indexes for faster queries
            $table->index('product_id');
            $table->index('user_id');
            $table->index('reference_id');
            $table->index('action_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
