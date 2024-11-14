<?php

namespace Database\Factories;

use App\Models\DeliveryType;
use App\Models\PackageStatus;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'tracking_code' => fake()->unique()->regexify('[A-Z0-9]{10}'),
            'commune_id' => fake()->numberBetween(1, 1541),
            'delivery_type_id' => fake()->numberBetween(1, 3),
            'status_id' => fake()->numberBetween(1, 8),
            'store_id' => Store::factory(),
            'address' => fake()->address(),
            'can_be_opened' => fake()->boolean(80), // 80% true chance
            'name' => fake()->sentence(),
            'client_first_name' => fake()->firstName(),
            'client_last_name' => fake()->lastName(),
            'client_phone' => fake()->phoneNumber(),
            'client_phone2' => fake()->phoneNumber(),
            'cod_to_pay' => fake()->randomFloat(2, 100, 5000),
            'commission' => fake()->randomFloat(2, 100, 5000),
            'status_updated_at' => fake()->dateTimeThisMonth('-10 days'),
            'delivered_at' => fake()->dateTimeThisMonth('-10 days'),
            'delivery_price' => fake()->randomFloat(2, 100, 5000),
            'extra_weight_price' => fake()->randomNumber(4, true),
            'free_delivery' => fake()->boolean(),
            'packaging_price' => fake()->numberBetween(0, 200),
            'partner_cod_price' => fake()->randomFloat(2, 0, 1000),
            'partner_delivery_price' => fake()->numberBetween(0, 1000),
            'partner_return' => fake()->randomFloat(2, 0, 1000),
            'price' => fake()->randomFloat(2, 0, 100000),
            'price_to_pay' => fake()->randomFloat(2, 0, 200000),
            'total_price' => fake()->randomFloat(2, 0, 500000),
            'weight' => fake()->numberBetween(1000, 30000),
        ];
    }
}
