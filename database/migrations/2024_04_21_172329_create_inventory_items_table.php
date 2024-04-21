<?php

use Core\Product\Enums\InventoryItemStatus;
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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('inventory_id')->constrained()->onDelete('cascade');
            $table->decimal('purchase_price', 10, 2); // Price you buy with
            $table->decimal('sell_price', 10, 2); // Price you sell for
            $table->integer('quantity');
            $table->string('brand')->nullable();
            $table->string('size')->nullable(); // Inventory-specific attributes
            $table->string('color')->nullable(); // Inventory-specific attributes
            $table->string('material')->nullable(); // Inventory-specific attributes
            $table->string('style')->nullable(); // Inventory-specific attributes
            $table->enum('status', array_map(fn($item) => $item->value, InventoryItemStatus::cases()))->default(InventoryItemStatus::InStock->value);
            $table->string('image')->nullable();
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable();
            // Add any other inventory-specific attributes here
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
