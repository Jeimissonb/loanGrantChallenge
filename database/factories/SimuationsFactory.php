<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SimuationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pretended_value' => fake(),
            'pretended_deadline' => fake(),
            'increased_value',
            'saved' => fake(),
            'id_user' => fake(),
        ];
    }
}
