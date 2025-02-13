<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'customer')->inRandomOrder()->first()->id ?? User::factory()->create(['role' => 'customer'])->id,
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory()->create()->id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'total_price' => function (array $attributes) {
                return Product::find($attributes['product_id'])->price * $attributes['quantity'];
            },
            'status' => $this->faker->randomElement(['pending', 'shipped', 'delivered', 'cancelled']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
