<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => ['admin', 'user', 'moderator'][rand(0,2)],
            'is_active' => true,
            'note' => $this->faker->text(),
        ];
    }
}