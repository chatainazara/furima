<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> User::factory(),
            'pict_url' => $this->faker->imageUrl(),
            'post_code' => $this->faker->regexify('[1-9]{3}-[0-9]{4}'),
            'address' => $this->faker->address(),
            'building'=>$this->faker->secondaryAddress(),
            'destination_post_code' => $this->faker->regexify('[1-9]{3}-[0-9]{4}'),
            'destination_address' => $this->faker->address(),
            'destination_building'=>$this->faker->secondaryAddress(),
        ];
    }
}
