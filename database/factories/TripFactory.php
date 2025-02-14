<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Trip;
use App\Models\Employee;
use App\Models\Departure;
use App\Models\Destination;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'departure_id' => Departure::factory(),
            'destination_id' => Destination::factory(),
            'flight_number' => strtoupper($this->faker->bothify('??###')),
            'departure_date' => $this->faker->date,
            'departure_time' => $this->faker->time,
            'arrival_date' => $this->faker->date,
            'arrival_time' => $this->faker->time,
            'trip_status' => $this->faker->randomElement(['Scheduled', 'Completed', 'Cancelled']),
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];
    }
}
