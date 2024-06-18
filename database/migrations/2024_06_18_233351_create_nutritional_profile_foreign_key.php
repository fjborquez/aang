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
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('nutritional_restriction_id')->references('id')->on('nutritional_restrictions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nutritional_profiles', function (Blueprint $table) {
            $table->dropForeign('nutritional_profiles_person_id_foreign');
            $table->dropForeign('nutritional_profiles_nutritional_restriction_id_foreign');
        });
    }
};
