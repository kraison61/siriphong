<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE categories MODIFY COLUMN type ENUM('product', 'service', 'portfolio') NOT NULL DEFAULT 'product'");
        } elseif ($driver === 'sqlite') {
            $this->rebuildSqliteCategoriesType(['product', 'service', 'portfolio']);
        }

        Schema::table('portfolios', function (Blueprint $table) {
            if (! Schema::hasColumn('portfolios', 'category_id')) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            }
        });

        if ($driver === 'sqlite') {
            $this->makeSqlitePortfolioCategoryLabelNullable();
        } else {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->string('category_label')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('portfolios', 'category_id')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropConstrainedForeignId('category_id');
            });
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE categories MODIFY COLUMN type ENUM('product', 'service') NOT NULL DEFAULT 'product'");
            Schema::table('portfolios', function (Blueprint $table) {
                $table->string('category_label')->nullable(false)->change();
            });
        } elseif ($driver === 'sqlite') {
            $this->rebuildSqliteCategoriesType(['product', 'service']);
        }
    }

    /**
     * @param  list<string>  $types
     */
    private function rebuildSqliteCategoriesType(array $types): void
    {
        $typeList = collect($types)
            ->map(fn (string $type) => "'".$type."'")
            ->implode(', ');

        Schema::disableForeignKeyConstraints();

        DB::statement("
            CREATE TABLE categories_new (
                id integer primary key autoincrement not null,
                name varchar not null,
                slug varchar not null,
                type varchar check (\"type\" in ({$typeList})) not null default 'product',
                sort_order integer not null default '0',
                created_at datetime,
                updated_at datetime
            )
        ");

        if (Schema::hasTable('categories')) {
            $allowed = collect($types)->map(fn (string $type) => "'".$type."'")->implode(', ');
            DB::statement("
                INSERT INTO categories_new (id, name, slug, type, sort_order, created_at, updated_at)
                SELECT id, name, slug, type, sort_order, created_at, updated_at
                FROM categories
                WHERE type IN ({$allowed})
            ");
            Schema::drop('categories');
        }

        Schema::rename('categories_new', 'categories');
        DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS categories_slug_unique ON categories (slug)');

        $this->rebuildSqliteProductsForeignKey();

        Schema::enableForeignKeyConstraints();
    }

    private function rebuildSqliteProductsForeignKey(): void
    {
        if (! Schema::hasTable('products')) {
            return;
        }

        DB::statement('
            CREATE TABLE products_new (
                id integer primary key autoincrement not null,
                category_id integer,
                type varchar check ("type" in (\'product\', \'service\')) not null default \'product\',
                name varchar not null,
                slug varchar not null,
                short_description text,
                description text,
                image varchar,
                price numeric not null default \'0\',
                sale_price numeric,
                is_active tinyint(1) not null default \'1\',
                is_featured tinyint(1) not null default \'0\',
                meta_title varchar,
                meta_description varchar,
                created_at datetime,
                updated_at datetime,
                sku varchar,
                brand varchar,
                mpn varchar,
                gtin13 varchar,
                specs text,
                foreign key("category_id") references "categories"("id") on delete set null
            )
        ');

        $columns = collect(DB::select('PRAGMA table_info(products)'))
            ->pluck('name')
            ->all();

        $desired = [
            'id', 'category_id', 'type', 'name', 'slug', 'short_description', 'description',
            'image', 'price', 'sale_price', 'is_active', 'is_featured', 'meta_title',
            'meta_description', 'created_at', 'updated_at', 'sku', 'brand', 'mpn', 'gtin13', 'specs',
        ];
        $select = collect($desired)
            ->filter(fn (string $column) => in_array($column, $columns, true))
            ->implode(', ');

        DB::statement("INSERT INTO products_new ({$select}) SELECT {$select} FROM products");
        Schema::drop('products');
        Schema::rename('products_new', 'products');
        DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS products_slug_unique ON products (slug)');
    }

    private function makeSqlitePortfolioCategoryLabelNullable(): void
    {
        if (! Schema::hasTable('portfolios') || ! Schema::hasColumn('portfolios', 'category_label')) {
            return;
        }

        // SQLite cannot ALTER COLUMN nullability — rebuild only if currently NOT NULL.
        $info = collect(DB::select('PRAGMA table_info(portfolios)'))
            ->firstWhere('name', 'category_label');

        if (! $info || (int) $info->notnull !== 1) {
            return;
        }

        Schema::disableForeignKeyConstraints();

        $createSql = DB::selectOne("SELECT sql FROM sqlite_master WHERE type='table' AND name='portfolios'")->sql;
        $createSql = str_replace(
            '"category_label" varchar not null',
            '"category_label" varchar',
            $createSql
        );
        $createSql = preg_replace('/^CREATE TABLE ["\']?portfolios["\']?/i', 'CREATE TABLE portfolios_new', $createSql);

        DB::statement($createSql);

        $columns = collect(DB::select('PRAGMA table_info(portfolios)'))
            ->pluck('name')
            ->implode(', ');

        DB::statement("INSERT INTO portfolios_new ({$columns}) SELECT {$columns} FROM portfolios");
        Schema::drop('portfolios');
        Schema::rename('portfolios_new', 'portfolios');

        if (Schema::hasColumn('portfolios', 'slug')) {
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS portfolios_slug_unique ON portfolios (slug)');
        }

        Schema::enableForeignKeyConstraints();
    }
};
