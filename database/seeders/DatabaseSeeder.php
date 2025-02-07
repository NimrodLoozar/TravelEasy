<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Person;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Contact;
use App\Models\Employee;
use App\Models\Departure;
use App\Models\Destination;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Communication;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->testuser()->create();
        User::factory()->admin()->create();

                // Create 50 people
                Person::factory()
                ->count(50)
                ->create();
    
            // Create 20 roles
            Role::factory()
                ->count(20)
                ->create();
    
            // Create 30 customers
            Customer::factory()
                ->count(30)
                ->create();
    
            // Create 30 contacts
            Contact::factory()
                ->count(30)
                ->create();
    
            // Create 20 employees
            Employee::factory()
                ->count(20)
                ->create();
    
            // Create 10 departures
            Departure::factory()
                ->count(10)
                ->create();
    
            // Create 10 destinations
            Destination::factory()
                ->count(10)
                ->create();
    
            // Create 20 trips
            Trip::factory()
                ->count(20)
                ->create();
    
            // Create 50 bookings
            Booking::factory()
                ->count(50)
                ->create();
    
            // Create 30 invoices
            Invoice::factory()
                ->count(30)
                ->create();
    
            // Create 20 communications
            Communication::factory()
                ->count(20)
                ->create();
    }
}
