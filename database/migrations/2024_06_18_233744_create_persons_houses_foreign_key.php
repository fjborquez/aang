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
        Schema::table('persons_houses', function (Blueprint $table) {
            $table->foreign('person_id')->on('persons')->references('id');
            $table->foreign('house_id')->on('houses')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persons_houses', function (Blueprint $table) {
            $table->dropForeign('persons_houses_person_id_foreign');
            $table->dropForeign('persons_houses_house_id_foreign');
        });
    }
};
