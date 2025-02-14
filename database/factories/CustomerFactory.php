<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
use App\Models\Person;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'person_id' => Person::factory(),
            'relation_number' => $this->faker->unique()->randomNumber(8),
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];
    }
}
