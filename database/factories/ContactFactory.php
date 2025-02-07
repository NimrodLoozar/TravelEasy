<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'street' => $this->faker->streetName(),
            'house_number' => $this->faker->buildingNumber(),
            'addition' => $this->faker->secondaryAddress(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->email(),
            'is_active' => true,
            'note' => $this->faker->text(),
        ];
    }
}