<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'image')) {
            Schema::table('products', function (Blueprint $table) {

                $table->string('image', 2048)
                      ->nullable()
                      ->comment('URL/path gambar utama produk');

            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'image')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }
};
