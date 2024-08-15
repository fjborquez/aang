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
            $table->unsignedBigInteger('house_role_id');
            $table->foreign('house_role_id')->references('id')->on('house_roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persons_houses', function (Blueprint $table) {
            $table->dropForeign('persons_houses_house_role_id_foreign');
        });
    }
};
