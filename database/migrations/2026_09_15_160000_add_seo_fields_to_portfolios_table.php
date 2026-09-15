<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('meta_title')->nullable()->after('map_coordinates');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
            $table->foreignId('related_blog_id')->nullable()->after('meta_description')->constrained('blogs')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropConstrainedForeignId('related_blog_id');
            $table->dropColumn(['slug', 'meta_title', 'meta_description']);
        });
    }
};
