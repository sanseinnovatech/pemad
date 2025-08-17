<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->decimal('base_price', 12, 2)->index();
            $table->unsignedInteger('stock')->default(0);
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->timestamps();

            $table->index(['category_id', 'base_price']);
            $table->index(['name']);
        });

        try {
            DB::statement('ALTER TABLE products ADD FULLTEXT fulltext_name_desc (name, description)');
        } catch (\Throwable $e) {

        }
    }
    public function down(): void {
        Schema::dropIfExists('products');
    }
};
