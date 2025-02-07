<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'person_id' => Person::factory(),
            'number' => 'EMP' . rand(1000, 9999),
            'employee_type' => ['Manager', 'Administrator', 'Desk Employee'][rand(0,2)],
            'is_active' => true,
            'note' => $this->faker->text(),
        ];
    }
}