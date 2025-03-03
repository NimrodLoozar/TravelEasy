<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Departure;

class DepartureFactory extends Factory
{
    protected $model = Departure::class;

    public function definition()
    {
        return [
            'country' => $this->faker->country,
            'airport' => $this->faker->city . ' International Airport',
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];
    }
}
