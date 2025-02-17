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
        $issueDate = $faker->dateTimeBetween('-10 years', 'now')->format('d-m-Y');
        $expiryDate = $faker->dateTimeBetween('now', '+10 years')->format('d-m-Y');
        $issuingAuthority = $faker->country; // Example: United States, India, United Kingdom

        // Combine details into a structured format
        $passportDetails = json_encode([
            'passport_number' => $passportNumber,
            'nationality' => $nationality,
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'issuing_authority' => $issuingAuthority,
        ]);

        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->lastName,
            'last_name' => $this->faker->lastName,
            'birth_date' => $this->faker->date,

            // PLEASE FIX THIS
            'passport_details' => $passportDetails, // Structured passport details
            'is_active' => true,


        ];
    }
}