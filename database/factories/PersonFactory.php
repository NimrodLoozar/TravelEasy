<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    public function definition()
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->optional()->firstName(),
            'last_name' => fake()->lastName(),
            'birth_date' => fake()->dateBetween('-70 years', '-18 years'),
            'passport_details' => fake()->optional()->regexify('[A-Z]{2}[0-9]{7}'),
            'is_active' => fake()->boolean(90),
            'note' => fake()->optional()->sentence(),
        ];
    }
}