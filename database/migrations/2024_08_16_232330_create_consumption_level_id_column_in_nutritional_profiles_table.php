<?php

use App\Models\ConsumptionLevel;
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
            $table->foreignIdFor(ConsumptionLevel::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nutritional_profiles', function (Blueprint $table) {
            $table->dropForeignIdFor(ConsumptionLevel::class);
        });
    }
};
