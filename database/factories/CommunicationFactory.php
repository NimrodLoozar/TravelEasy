// app/Database/Factories/CommunicationFactory.php

<?php

namespace Database\Factories;

use App\Models\Communication;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommunicationFactory extends Factory
{
    protected $model = Communication::class;

    public function definition()
    {
        return [
            'customer_id' => \App\Models\Customer::factory(),
            'employee_id' => \App\Models\Employee::factory(),
            'message' => $this->faker->text(),
            'sent_date' => $this->faker->date(),
            'is_active' => true,
            'note' => $this->faker->text(),
        ];
    }
}