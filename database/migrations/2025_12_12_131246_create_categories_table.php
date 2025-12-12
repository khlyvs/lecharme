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
        Schema::create('categories', function (Blueprint $table) {
                $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('position')->default(0);


            $table->string('slug_az')->nullable()->unique();
            $table->string('slug_en')->nullable()->unique();
            $table->string('slug_ru')->nullable()->unique();


            $table->string('name_az')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_ru')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
