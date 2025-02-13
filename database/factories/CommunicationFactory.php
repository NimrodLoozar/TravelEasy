<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Communication;
use App\Models\Customer;
use App\Models\Employee;

class CommunicationFactory extends Factory
{
    protected $model = Communication::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'employee_id' => Employee::factory(),
            'message' => $this->faker->paragraph,
            'sent_date' => $this->faker->date,
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];
    }
}
