<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (! Schema::hasColumn('blogs', 'primary_keyword')) {
                $table->string('primary_keyword')->nullable()->after('slug');
            }
            if (! Schema::hasColumn('blogs', 'image_alt')) {
                $table->string('image_alt')->nullable()->after('image');
            }
            if (! Schema::hasColumn('blogs', 'image_width')) {
                $table->unsignedSmallInteger('image_width')->nullable()->after('image_alt');
            }
            if (! Schema::hasColumn('blogs', 'image_height')) {
                $table->unsignedSmallInteger('image_height')->nullable()->after('image_width');
            }
            if (! Schema::hasColumn('blogs', 'author_name')) {
                $table->string('author_name')->nullable()->after('image_height');
            }
            if (! Schema::hasColumn('blogs', 'author_job_title')) {
                $table->string('author_job_title')->nullable()->after('author_name');
            }
            if (! Schema::hasColumn('blogs', 'author_description')) {
                $table->string('author_description', 500)->nullable()->after('author_job_title');
            }
            if (! Schema::hasColumn('blogs', 'faqs')) {
                $table->json('faqs')->nullable()->after('author_description');
            }
            if (! Schema::hasColumn('blogs', 'related_portfolio_id')) {
                $table->foreignId('related_portfolio_id')->nullable()->after('meta_description')->constrained('portfolios')->nullOnDelete();
            }
            if (! Schema::hasColumn('blogs', 'content_updated_at')) {
                $table->timestamp('content_updated_at')->nullable()->after('published_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (Schema::hasColumn('blogs', 'related_portfolio_id')) {
                $table->dropConstrainedForeignId('related_portfolio_id');
            }

            $columns = [
                'primary_keyword',
                'image_alt',
                'image_width',
                'image_height',
                'author_name',
                'author_job_title',
                'author_description',
                'faqs',
                'content_updated_at',
            ];

            $existing = array_values(array_filter(
                $columns,
                fn (string $column) => Schema::hasColumn('blogs', $column)
            ));

            if ($existing !== []) {
                $table->dropColumn($existing);
            }
        });
    }
};
