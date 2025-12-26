<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Subcategories cədvəlinə slug index-ləri
        Schema::table('subcategories', function (Blueprint $table) {
            $table->index('slug_az', 'idx_subcategories_slug_az');
            $table->index('slug_en', 'idx_subcategories_slug_en');
            $table->index('slug_ru', 'idx_subcategories_slug_ru');
        });

        // Products cədvəlinə composite index
        Schema::table('products', function (Blueprint $table) {
            $table->index(['is_active', 'subcategory_id'], 'idx_products_active_subcategory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropIndex('idx_subcategories_slug_az');
            $table->dropIndex('idx_subcategories_slug_en');
            $table->dropIndex('idx_subcategories_slug_ru');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_active_subcategory');
        });
    }
};
