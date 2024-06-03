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
            $table->unsignedBigInteger('house_role_id')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persons_houses', function (Blueprint $table) {
            $table->dropColumn('house_role_id');
        });
    }
};
