<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['balance' => "int", 'account_number' => "string"])]
    public function definition(): array
    {
        return [
            'balance' => fake()->numberBetween(10000000, 1000000000),
            'account_number' => fake()->regexify('[0-9][0-9]{19}')
        ];
    }
}
