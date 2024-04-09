<?php

use App\Models\NutritionalRestriction;
use App\Models\Person;
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
        Schema::create('nutritional_profiles', function (Blueprint $table) {
            $table->foreignIdFor(Person::class);
            $table->foreignIdFor(NutritionalRestriction::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutritional_profiles');
    }
};
