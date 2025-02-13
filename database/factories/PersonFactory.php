<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->lastName,
            'last_name' => $this->faker->lastName,
            'birth_date' => $this->faker->date,
            'passport_details' => $this->faker->optional()->text,
            'is_active' => true,
            'note' => $this->faker->optional()->text,
        ];
    }
}
