<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('sku')->unique();
            $table->string('option_name')->nullable();   // contoh: color, size
            $table->string('option_value')->nullable();  // contoh: red, XL
            $table->decimal('price', 12, 2)->nullable(); // override dari base_price
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();

            $table->index(['product_id', 'option_name', 'option_value']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('product_variants');
    }
};
