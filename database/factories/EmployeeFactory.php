<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\Person;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'person_id' => Person::factory(),
            'number' => $this->faker->unique()->randomNumber(6),
            'employee_type' => $this->faker->randomElement(['Manager', 'Administrator', 'Desk Employee']),
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];
    }
}
