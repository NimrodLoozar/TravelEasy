<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Invoice;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Contact;
use App\Models\Employee;
use App\Models\Departure;
use App\Models\Destination;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\Communication;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Eerst mensen genereren, omdat veel andere tabellen hieraan gekoppeld zijn
        $people = Person::factory()->count(10)->create();

        // Maak een admin en testgebruiker (specifieke users)
        User::factory()->testuser()->create();
        User::factory()->admin()->create();

        // Maak 10 facturen aan
        Invoice::factory()->count(10)->create();
    }
}
