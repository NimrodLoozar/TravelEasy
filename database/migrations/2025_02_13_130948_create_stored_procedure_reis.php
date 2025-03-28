<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spEditReis;
            CREATE PROCEDURE spEditReis(
                IN departure_id INT,
                IN departure_country VARCHAR(255),
                IN departure_airport VARCHAR(255),
                IN arrival_country VARCHAR(255),
                IN arrival_airport VARCHAR(255),
                IN trip_id INT,
                IN departure_date DATE,
                IN departure_time TIME,
                IN arrival_date DATE,
                IN arrival_time TIME
            )
            BEGIN
                -- Update departures table
                UPDATE departures
                SET country = departure_country, airport = departure_airport
                WHERE id = departure_id;

                -- Update destinations table
                UPDATE destinations
                SET country = arrival_country, airport = arrival_airport
                WHERE id = (SELECT destination_id FROM trips WHERE id = trip_id);

                -- Update trips table
                UPDATE trips
                SET departure_date = departure_date, departure_time = departure_time,
                    arrival_date = arrival_date, arrival_time = arrival_time
                WHERE id = trip_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spEditReis');
    }
};
