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
        Schema::table('nutritional_profiles', function (Blueprint $table) {
            $table->unsignedInteger('product_category_id');
            $table->string('product_category_name', 30);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nutritional_profiles', function (Blueprint $table) {
            $table->dropColumn('product_category_id');
            $table->dropColumn('product_category_name');
        });
    }
};
