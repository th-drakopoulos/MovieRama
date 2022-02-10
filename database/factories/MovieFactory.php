<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(random_int(4, 7)),
            'likes' => random_int(0, 10),
            'hates' => random_int(0, 10),
            'user_id' => random_int(1, 10),
        ];
    }
}