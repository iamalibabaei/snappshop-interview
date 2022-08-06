<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['amount' => "int"])]
    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(10000, 500000000),
        ];
    }
}
