<?php

use App\Models\NutritionalRestriction;
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
            $table->dropForeignIdFor(NutritionalRestriction::class, 'nutritional_restriction_id');
            $table->dropColumn('nutritional_restriction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nutritional_profiles', function (Blueprint $table) {
            $table->foreignIdFor(NutritionalRestriction::class, 'nutritional_restriction_id');
        });
    }
};
