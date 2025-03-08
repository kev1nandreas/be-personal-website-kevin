<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->word(),
            'destination' => $this->faker->url(),
            'user_id' => '0c35f54a-5917-4c98-b8e9-29110caac8a4',
            'active' => true,
            'expires_at' => null,
            'visits' => 0,
        ];
    }
}
