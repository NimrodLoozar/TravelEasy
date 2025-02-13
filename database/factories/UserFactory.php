<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Customer;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $person = Person::factory()->create();

        $user = [
            'person_id' => $person->id,
            'name' => $this->faker->userName,
            'password' => static::$password ??= Hash::make('password'),
            'is_logged_in' => false,
            'logged_in' => null,
            'logged_out' => null,
            'is_active' => true,
            'note' => null,
            'remember_token' => Str::random(10),
        ];

        $relationNumber = 'REL' . str_pad(Customer::max('id') + 1, 8, '0', STR_PAD_LEFT);

        Customer::create([
            'person_id' => $person->id,
            'relation_number' => $relationNumber,
        ]);

        return $user;
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function testuser(): static
    {
        return $this->state(function (array $attributes) {
            $person = Person::factory()->create([
                'first_name' => 'Test',
                'last_name' => 'User',
            ]);

            $relationNumber = 'REL' . str_pad(Customer::max('id') + 1, 8, '0', STR_PAD_LEFT);

            $customer = Customer::create([
                'person_id' => $person->id,
                'relation_number' => $relationNumber,
            ]);

            Contact::create([
                'customer_id' => $customer->id,
                'email' => 'test@gmail.com',
                // ...other required fields for Contact model...
            ]);

            return [
                'person_id' => $person->id,
                'name' => 'TestUser',
                'password' => Hash::make('Test1234'),
            ];
        });
    }

    public function admin(): static
    {
        return $this->state(function (array $attributes) {
            $person = Person::factory()->create([
                'first_name' => 'Admin',
                'last_name' => 'User',
            ]);

            $relationNumber = 'REL' . str_pad(Customer::max('id') + 1, 8, '0', STR_PAD_LEFT);

            $customer = Customer::create([
                'person_id' => $person->id,
                'relation_number' => $relationNumber,
            ]);

            Contact::create([
                'customer_id' => $customer->id,
                'email' => 'admin@gmail.com',
                // ...other required fields for Contact model...
            ]);

            return [
                'person_id' => $person->id,
                'name' => 'AdminUser',
                'password' => Hash::make('Admin1234'),
            ];
        });
    }
}