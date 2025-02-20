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
        // Ophalen van alle facturen met volledige gegevens
        DB::unprepared('
          DROP PROCEDURE IF EXISTS spGetInvoices;
            CREATE PROCEDURE spGetInvoices()
            BEGIN
                SELECT 
                    invoices.id, invoices.number, invoices.date, invoices.status,
                    invoices.amount_excl_vat, invoices.vat, invoices.amount_incl_vat, invoices.note,
                    bookings.id AS booking_id, bookings.seat_number, bookings.price, bookings.quantity,
                    trips.id AS trip_id, trips.flight_number, trips.departure_date, trips.arrival_date,
                    customers.id AS customer_id, people.first_name, people.last_name, contacts.email
                FROM invoices
                JOIN bookings ON invoices.booking_id = bookings.id
                JOIN customers ON bookings.customer_id = customers.id
                JOIN people ON customers.person_id = people.id
                LEFT JOIN contacts ON contacts.customer_id = customers.id
                JOIN trips ON bookings.trip_id = trips.id
                ORDER BY invoices.id DESC;
            END;

        ');

        // Ophalen van een specifieke factuur op ID
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spGetInvoiceById;
            CREATE PROCEDURE spGetInvoiceById(IN invoice_id INT)
            BEGIN
                SELECT 
                    invoices.id, invoices.number, invoices.date, invoices.status,
                    invoices.amount_excl_vat, invoices.vat, invoices.amount_incl_vat, invoices.note,
                    bookings.id AS booking_id, bookings.seat_number, bookings.price, bookings.quantity,
                    trips.id AS trip_id, trips.flight_number, trips.departure_date, trips.arrival_date,
                    customers.id AS customer_id, people.first_name, people.last_name, contacts.email
                FROM invoices
                JOIN bookings ON invoices.booking_id = bookings.id
                JOIN customers ON bookings.customer_id = customers.id
                JOIN people ON customers.person_id = people.id
                LEFT JOIN contacts ON contacts.customer_id = customers.id
                JOIN trips ON bookings.trip_id = trips.id
                WHERE invoices.id = invoice_id;
            END;

        ');

        // Toevoegen van een factuur
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spAddInvoice;
            CREATE PROCEDURE spAddInvoice(
                IN number INT, 
                IN date DATE, 
                IN status VARCHAR(50), 
                IN amount_excl_vat DECIMAL(10,2), 
                IN vat DECIMAL(10,2), 
                IN amount_incl_vat DECIMAL(10,2), 
                IN note TEXT, 
                IN booking_id INT
            )
            BEGIN
                INSERT INTO invoices (number, date, status, amount_excl_vat, vat, amount_incl_vat, note, booking_id)
                VALUES (number, date, status, amount_excl_vat, vat, amount_incl_vat, note, booking_id);
            END
        ');

        // Updaten van een factuur
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spUpdateInvoice;
            CREATE PROCEDURE spUpdateInvoice(
                IN invoice_id INT, 
                IN date DATE, 
                IN status VARCHAR(50), 
                IN amount_excl_vat DECIMAL(10,2), 
                IN vat DECIMAL(10,2), 
                IN amount_incl_vat DECIMAL(10,2), 
                IN note TEXT
            )
            BEGIN
                UPDATE invoices 
                SET date = date, status = status, amount_excl_vat = amount_excl_vat, 
                    vat = vat, amount_incl_vat = amount_incl_vat, note = note
                WHERE id = invoice_id;
            END
        ');

        // Verwijderen van een factuur
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spDeleteInvoice;
            CREATE PROCEDURE spDeleteInvoice(IN invoice_id INT)
            BEGIN
                DELETE FROM invoices WHERE id = invoice_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetInvoices');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetInvoiceById');
        DB::unprepared('DROP PROCEDURE IF EXISTS spAddInvoice');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateInvoice');
        DB::unprepared('DROP PROCEDURE IF EXISTS spDeleteInvoice');
    }
};
