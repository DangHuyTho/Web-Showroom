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
        // The packed_at, shipped_at, delivered_at columns already exist
        // We just need to update the status enum to include 'packed'
        
        if (DB::connection()->getDriverName() === 'sqlite') {
            // For SQLite, we need to recreate the table with modified column
            DB::statement("
                CREATE TABLE orders_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    user_id INTEGER NOT NULL,
                    total_amount DECIMAL(15, 2) DEFAULT 0,
                    status TEXT CHECK(status IN ('pending', 'confirmed', 'processing', 'packed', 'shipped', 'delivered', 'cancelled')) DEFAULT 'pending',
                    delivery_address TEXT,
                    phone VARCHAR(255),
                    notes TEXT,
                    payment_id INTEGER,
                    packed_at TIMESTAMP,
                    shipped_at TIMESTAMP,
                    delivered_at TIMESTAMP,
                    created_at TIMESTAMP,
                    updated_at TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY (payment_id) REFERENCES payments(id) ON DELETE SET NULL
                )
            ");
            
            DB::statement("
                INSERT INTO orders_new 
                SELECT id, user_id, total_amount, status, delivery_address, phone, notes, payment_id, packed_at, shipped_at, delivered_at, created_at, updated_at
                FROM orders
            ");
            
            DB::statement("DROP TABLE orders");
            DB::statement("ALTER TABLE orders_new RENAME TO orders");
        } else {
            // For MySQL/PostgreSQL
            Schema::table('orders', function (Blueprint $table) {
                $table->string('status')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration only updates the enum constraint
        // Rolling back would require recreating the table again, so we skip it
    }
};
