<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            create definer = aang@`%` trigger check_unique_house_per_city_per_person
                before insert
                on persons_houses
                for each row
            BEGIN
                DECLARE duplicate_count INT;

                SELECT COUNT(*)
                INTO duplicate_count
                FROM persons_houses ph
                JOIN houses h ON ph.house_id = h.id
                WHERE ph.person_id = NEW.person_id
                AND h.description = (SELECT description FROM houses WHERE id = NEW.house_id)
                AND h.city_id = (SELECT city_id FROM houses WHERE id = NEW.house_id);

                IF duplicate_count > 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'A person cannot have a house with the same description in the same city.';
                END IF;
            END;
        ");

        DB::unprepared("
            create definer = aang@`%` trigger ensure_single_default_house
                before insert
                on persons_houses
                for each row
            BEGIN
                DECLARE default_count INT;

                IF NEW.is_default = 1 THEN
                    -- Contar cuántas casas por defecto tiene la persona
                    SELECT COUNT(*)
                    INTO default_count
                    FROM persons_houses
                    WHERE person_id = NEW.person_id AND is_default = 1;

                    -- Si ya tiene una casa por defecto, detener la operación
                    IF default_count > 0 THEN
                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'A person must only have one default house.';
                    END IF;
                END IF;
            END;
        ");

        DB::unprepared("
            create definer = aang@`%` trigger ensure_single_default_house_update
                before update
                on persons_houses
                for each row
            BEGIN
                DECLARE default_count INT;

                IF NEW.is_default = 1 AND OLD.is_default != 1 THEN
                    -- Contar cuántas casas por defecto tiene la persona
                    SELECT COUNT(*)
                    INTO default_count
                    FROM persons_houses
                    WHERE person_id = NEW.person_id AND is_default = 1;

                    -- Si ya tiene una casa por defecto, detener la operación
                    IF default_count > 0 THEN
                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = '[NOT UPDATE] A person must only have one default house.';
                    END IF;
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `check_unique_house_per_city_per_person`');
        DB::unprepared('DROP TRIGGER `ensure_single_default_house`');
        DB::unprepared('DROP TRIGGER `ensure_single_default_house_update`');
    }
};
