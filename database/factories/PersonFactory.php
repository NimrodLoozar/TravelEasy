<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();

        // Generate realistic passport details
        $passportNumber = strtoupper($faker->bothify('??######')); // Example: AB123456
        $nationality = $faker->countryCode; // Example: US, IN, GB
        $issueDate = $faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d');
        $expiryDate = $faker->dateTimeBetween('now', '+10 years')->format('Y-m-d');
        $issuingAuthority = $faker->country; // Example: United States, India, United Kingdom

        // Combine details into a structured format
        $passportDetails = [
            'passport_number' => $passportNumber,
            'nationality' => $nationality,
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'issuing_authority' => $issuingAuthority,
        ];

        return [
            'first_name' => $faker->firstName,
            'middle_name' => $faker->optional()->lastName,
            'last_name' => $faker->lastName,
            'birth_date' => $faker->date,

            // Fixed passport details
            'passport_details' => json_encode($passportDetails), // Encode as JSON
            'is_active' => true,
        ];
    }
}