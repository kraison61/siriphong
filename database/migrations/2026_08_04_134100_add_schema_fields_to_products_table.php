<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('slug');
            $table->string('brand')->nullable()->after('sku');
            $table->string('mpn')->nullable()->after('brand');
            $table->string('gtin13', 13)->nullable()->after('mpn');
            $table->json('specs')->nullable()->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku', 'brand', 'mpn', 'gtin13', 'specs']);
        });
    }
};
