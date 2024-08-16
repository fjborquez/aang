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
        Schema::create('consumption_levels', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('value')->unique();
            $table->string('name', 12)->unique();
            $table->string('description', 150)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumption_levels');
    }
};
