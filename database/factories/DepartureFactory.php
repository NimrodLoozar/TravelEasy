<?php

namespace Database\Factories;

use App\Models\Departure;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartureFactory extends Factory
{
    protected $model = Departure::class;

    public function definition()
    {
        return [
            'country' => $this->faker->country(),
            'airport' => $this->faker->city(),
            'is_active' => true,
            'note' => $this->faker->text(),
        ];
    }
}