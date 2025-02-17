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
        // Get all accounts - Updated with all fields needed for index
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spGetAccounts;
            CREATE PROCEDURE spGetAccounts()
            BEGIN
                SELECT 
                    c.id,
                    p.first_name,
                    p.middle_name,
                    p.last_name,
                    CONCAT(p.first_name, \' \', IFNULL(p.middle_name, \'\'), \' \', p.last_name) AS full_name,
                    p.birth_date,
                    p.passport_details,
                    c.relation_number,
                    co.email,
                    co.mobile,
                    co.street,
                    co.house_number,
                    co.addition,
                    co.postal_code,
                    co.city,
                    c.is_active,
                    c.created_at
                FROM customers c
                INNER JOIN people p ON c.person_id = p.id
                LEFT JOIN contacts co ON c.id = co.customer_id
                WHERE co.email IS NOT NULL 
                AND co.mobile IS NOT NULL
                ORDER BY c.created_at DESC;
            END
        ');

        // Get account by ID
        DB::unprepared('
        DROP PROCEDURE IF EXISTS spGetAccountById;
            CREATE PROCEDURE spGetAccountById(IN accountId INT)
            BEGIN
                SELECT 
                    c.id,
                    p.first_name,
                    p.middle_name,
                    p.last_name,
                    CONCAT(p.first_name, \' \', IFNULL(p.middle_name, \'\'), \' \', p.last_name) AS full_name,
                    p.birth_date,
                    p.passport_details,
                    c.relation_number,
                    co.email,
                    co.mobile,
                    co.street,
                    co.house_number,
                    co.addition,
                    co.postal_code,
                    co.city,
                    c.is_active,
                    c.created_at
                FROM customers c
                INNER JOIN people p ON c.person_id = p.id
                LEFT JOIN contacts co ON c.id = co.customer_id
                WHERE c.id = accountId;
            END
        ');

        // Add new account
        DB::unprepared('
        DROP PROCEDURE IF EXISTS spAddAccount;
            CREATE PROCEDURE spAddAccount(
                IN p_first_name VARCHAR(255),
                IN p_middle_name VARCHAR(255),
                IN p_last_name VARCHAR(255),
                IN p_birth_date DATE,
                IN p_passport_details JSON,
                IN p_relation_number VARCHAR(255),
                IN p_email VARCHAR(255),
                IN p_mobile VARCHAR(255),
                IN p_street VARCHAR(255),
                IN p_house_number VARCHAR(10),
                IN p_addition VARCHAR(10),
                IN p_postal_code VARCHAR(10),
                IN p_city VARCHAR(255),
                IN p_is_active BOOLEAN
            )
            BEGIN
                DECLARE new_person_id INT;
                DECLARE new_customer_id INT;
                
                START TRANSACTION;
                
                INSERT INTO people (
                    first_name, middle_name, last_name, 
                    birth_date, passport_details, is_active
                )
                VALUES (
                    p_first_name, p_middle_name, p_last_name, 
                    p_birth_date, p_passport_details, p_is_active
                );
                
                SET new_person_id = LAST_INSERT_ID();
                
                INSERT INTO customers (person_id, relation_number, is_active)
                VALUES (new_person_id, p_relation_number, p_is_active);
                
                SET new_customer_id = LAST_INSERT_ID();
                
                INSERT INTO contacts (
                    customer_id, email, mobile, 
                    street, house_number, addition, 
                    postal_code, city, is_active
                )
                VALUES (
                    new_customer_id, p_email, p_mobile, 
                    p_street, p_house_number, p_addition, 
                    p_postal_code, p_city, p_is_active
                );
                
                COMMIT;
            END
        ');

        // Update account
        DB::unprepared('
        DROP PROCEDURE IF EXISTS spUpdateAccount;
            CREATE PROCEDURE spUpdateAccount(
                IN p_id INT,
                IN p_first_name VARCHAR(255),
                IN p_middle_name VARCHAR(255),
                IN p_last_name VARCHAR(255),
                IN p_relation_number VARCHAR(255),
                IN p_email VARCHAR(255),
                IN p_mobile VARCHAR(255),
                IN p_is_active BOOLEAN
            )
            BEGIN
                DECLARE customer_person_id INT;
                
                START TRANSACTION;
                
                SELECT person_id INTO customer_person_id
                FROM customers
                WHERE id = p_id;
                
                UPDATE people
                SET first_name = p_first_name,
                    middle_name = p_middle_name,
                    last_name = p_last_name
                WHERE id = customer_person_id;
                
                UPDATE customers
                SET relation_number = p_relation_number,
                    is_active = p_is_active
                WHERE id = p_id;
                
                UPDATE contacts
                SET email = p_email,
                    mobile = p_mobile
                WHERE customer_id = p_id;
                
                COMMIT;
            END
        ');

        // Delete account
        DB::unprepared('
        DROP PROCEDURE IF EXISTS spDeleteAccount;
            CREATE PROCEDURE spDeleteAccount(IN accountId INT)
            BEGIN
                DECLARE customer_person_id INT;
                
                START TRANSACTION;
                
                SELECT person_id INTO customer_person_id
                FROM customers
                WHERE id = accountId;
                
                UPDATE contacts SET is_active = 0 WHERE customer_id = accountId;
                UPDATE customers SET is_active = 0 WHERE id = accountId;
                UPDATE people SET is_active = 0 WHERE id = customer_person_id;
                
                COMMIT;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAccounts;');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAccountById;');
        DB::unprepared('DROP PROCEDURE IF EXISTS spAddAccount;');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateAccount;');
        DB::unprepared('DROP PROCEDURE IF EXISTS spDeleteAccount;');
    }
};
