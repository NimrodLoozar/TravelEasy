<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'person_id' => Person::factory(),
            'relation_number' => 'CUS' . rand(10000, 99999),
            'is_active' => true,
            'note' => $this->faker->text(),
        ];
    }
}