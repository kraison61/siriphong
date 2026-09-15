<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->longText('content')->nullable()->after('description');
            $table->string('before_image')->nullable()->after('image');
            $table->string('after_image')->nullable()->after('before_image');
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['content', 'before_image', 'after_image']);
        });
    }
};
