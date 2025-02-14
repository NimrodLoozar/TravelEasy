<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;
use App\Models\Customer;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'addition' => $this->faker->optional()->randomLetter,
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'mobile' => $this->faker->optional()->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];
    }
}
