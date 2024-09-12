<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "content" => $this->faker->sentence,
            'user_id' => $this->faker->randomElement(['1', '2']),
            'visibility' => $this->faker->randomElement(['public', 'secret']),
        ];
    }
}
