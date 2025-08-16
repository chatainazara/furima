<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $statuses = ['良好', '目立った傷や汚れなし', 'やや傷や汚れあり','状態が悪い'];

        return [
            'user_id'=> User::factory(),
            'name' => $this->faker->unique()->text(20),
            'pict_url' => '',
            'brand_name' => $this->faker->company(),
            'price' => $this->faker->numberBetween(1000, 100000),
            'detail' => $this->faker->sentence(),
            'condition' => $this->faker->randomElement($statuses),
            'sold' => $this->faker->boolean(100),
        ];
    }
}
