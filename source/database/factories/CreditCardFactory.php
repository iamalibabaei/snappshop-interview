<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class CreditCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['card_number' => "string"])]
    public function definition(): array
    {
        return [
            'card_number' => fake()->regexify('60379981[0-9]{8}')
        ];
    }
}
