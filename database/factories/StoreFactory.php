<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->regexify('[A-Z0-9]{10}'),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phones' => fake()->phoneNumber(),
            'company_name' => fake()->company(),
            'capital' => fake()->randomNumber(3) * fake()->randomElement([100000, 1000000, 100000000]),
            'address' => fake()->address(),
            'register_commerce_number' => fake()->numerify('##########'),
            'nif' => fake()->numerify('################'),
            'legal_form' => fake()->randomNumber(1),
            'status' => 1,
            'can_update_preparing_packages' => fake()->boolean(),
        ];
    }
}
