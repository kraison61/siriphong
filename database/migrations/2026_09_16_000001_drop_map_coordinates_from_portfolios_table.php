<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('portfolios', 'map_coordinates')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropColumn('map_coordinates');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('portfolios', 'map_coordinates')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->string('map_coordinates')->nullable()->after('is_active');
            });
        }
    }
};
