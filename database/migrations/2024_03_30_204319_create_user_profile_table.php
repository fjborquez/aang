<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_birth');
            $table->boolean('is_vegetarian');
            $table->boolean('is_vegan');
            $table->boolean('is_celiac');
            $table->boolean('is_keto');
            $table->boolean('is_diabetic');
            $table->boolean('is_lactose');
            $table->boolean('is_gluten');
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
