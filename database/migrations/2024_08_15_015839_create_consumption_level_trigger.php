<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
             create definer = aang@`%` trigger check_consumption_level_accepted_values
                BEFORE INSERT ON consumption_levels
                FOR EACH ROW
                BEGIN
                    IF NEW.value < 0 OR NEW.value > 5 THEN
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Value must be between 0 and 5';
                    END IF;
                END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumption_level_trigger');
    }
};
