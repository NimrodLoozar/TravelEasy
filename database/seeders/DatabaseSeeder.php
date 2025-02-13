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
        // Eerst mensen genereren, omdat veel andere tabellen hieraan gekoppeld zijn
        $people = Person::factory()->count(50)->create();

        // Maak een admin en testgebruiker (specifieke users)
        User::factory()->testuser()->create();
        User::factory()->admin()->create();

        // Nu de rest van de gebruikers (gekoppeld aan een persoon)
        User::factory()->count(20)->create();

        // Rollen aanmaken
        Role::factory()->count(20)->create();

        // Klanten aanmaken (gekoppeld aan een persoon)
        $customers = Customer::factory()->count(30)->create();

        // Contactgegevens van klanten
        Contact::factory()->count(30)->create();

        // Werknemers aanmaken (gekoppeld aan een persoon)
        $employees = Employee::factory()->count(20)->create();

        // Luchthavens en bestemmingen
        $departures = Departure::factory()->count(10)->create();
        $destinations = Destination::factory()->count(10)->create();

        // Reizen genereren (gekoppeld aan medewerkers, luchthavens)
        $trips = Trip::factory()
            ->count(20)
            ->create();

        // Boekingen (gekoppeld aan klanten en reizen)
        $bookings = Booking::factory()
            ->count(50)
            ->create();

        // Facturen (gekoppeld aan boekingen)
        // Invoice::factory()
        //     ->count(30)
        //     ->create();

        // Communicatie tussen klanten en medewerkers
        Communication::factory()
            ->count(20)
            ->create();
    }
}
