<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\User;
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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create base roles
        $roles = Role::factory()
            ->count(5) // Reduced from 10 as most systems don't need that many roles
            ->create();

        // Create people first as they're the base for many relationships
        $people = Person::factory()
            ->count(42) // Increased to accommodate all relationships
            ->create();

        // Create specific users
        $adminUser = User::factory()->admin()->create();
        $testUser = User::factory()->testuser()->create();

        // Create regular users with person relationships
        $users = User::factory()
            ->count(10)
            ->state(function () use ($people) {
                return [
                    'person_id' => $people->random()->id,
                ];
            })
            ->create();

        // Create customers with person relationships
        $customers = Customer::factory()
            ->count(20)
            ->state(function () use ($people) {
                return [
                    'person_id' => $people->random()->id,
                ];
            })
            ->create();

        // Create contacts for customers
        Contact::factory()
            ->count(20) // Increased to match customer count
            ->state(function () use ($customers) {
                return [
                    'customer_id' => $customers->random()->id,
                ];
            })
            ->create();

        // Create employees with person relationships
        $employees = Employee::factory()
            ->count(10)
            ->state(function () use ($people) {
                return [
                    'person_id' => $people->random()->id,
                ];
            })
            ->create();

        // Create departures and destinations
        $departures = Departure::factory()
            ->count(10)
            ->create();

        $destinations = Destination::factory()
            ->count(20) // Increased for more variety
            ->create();

        // Create trips with proper relationships
        $trips = Trip::factory()
            ->count(30)
            ->state(function () use ($employees, $departures, $destinations) {
                return [
                    'employee_id' => $employees->random()->id,
                    'departure_id' => $departures->random()->id,
                    'destination_id' => $destinations->random()->id,
                ];
            })
            ->create();

        // Create bookings with proper relationships
        $bookings = Booking::factory()
            ->count(40)
            ->state(function () use ($customers, $trips) {
                return [
                    'customer_id' => $customers->random()->id,
                    'trip_id' => $trips->random()->id,
                ];
            })
            ->create();

        // Create invoices for bookings
        // Invoice::factory()
        //     ->count(40) // Match booking count
        //     ->state(function () use ($bookings) {
        //         return [
        //             'booking_id' => $bookings->random()->id,
        //         ];
        //     })
        //     ->create();

        // Create communications between customers and employees
        Communication::factory()
            ->count(10)
            ->state(function () use ($customers, $employees) {
                return [
                    'customer_id' => $customers->random()->id,
                    'employee_id' => $employees->random()->id,
                ];
            })
            ->create();
    }
}