<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\models\Invoice;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::unprepared('
            DROP PROCEDURE IF EXISTS spGetInvoices;
            CREATE PROCEDURE spGetInvoices()

            BEGIN
                SELECT * FROM invoices, bookings WHERE invoices.booking_id = bookings.id 
                
                ORDER BY id DESC;
            END
        ');

        DB::unprepared('
        DROP PROCEDURE IF EXISTS spGetInvoiceById;
            CREATE PROCEDURE spGetInvoiceById(IN invoice_id INT)
            BEGIN
                SELECT * FROM invoices WHERE id = invoice_id;
            END
        ');

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
