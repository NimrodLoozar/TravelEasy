<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;

class DestinationFactory extends Factory
{
    protected $model = Destination::class;

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