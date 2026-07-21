<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('portfolios', 'map_coordinates')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->string('map_coordinates')->nullable()->after('is_active');
            });
        }

        $hasLatitude = Schema::hasColumn('portfolios', 'map_latitude');
        $hasLongitude = Schema::hasColumn('portfolios', 'map_longitude');

        if ($hasLatitude && $hasLongitude) {
            DB::table('portfolios')
                ->whereNull('map_coordinates')
                ->whereNotNull('map_latitude')
                ->whereNotNull('map_longitude')
                ->orderBy('id')
                ->chunkById(100, function ($rows): void {
                    foreach ($rows as $row) {
                        DB::table('portfolios')
                            ->where('id', $row->id)
                            ->update([
                                'map_coordinates' => $row->map_latitude.', '.$row->map_longitude,
                            ]);
                    }
                });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('portfolios', 'map_coordinates')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropColumn('map_coordinates');
            });
        }
    }
};
