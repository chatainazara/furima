<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;

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
        $categories = [
            ['id' => '1','content' => 'ファッション'],
            ['id' => '2','content' => '家電'],
            ['id' => '3','content' => 'インテリア'],
            ['id' => '4','content' => 'レディース'],
            ['id' => '5','content' => 'メンズ'],
            ['id' => '6','content' => 'コスメ'],
            ['id' => '7','content' => '本'],
            ['id' => '8','content' => 'ゲーム'],
            ['id' => '0','content' => 'スポーツ'],
            ['id' => '10','content' => 'キッチン'],
            ['id' => '11','content' => 'ハンドメイド'],
            ['id' => '12','content' => 'アクセサリー'],
            ['id' => '13','content' => 'おもちゃ'],
            ['id' => '14','content' => 'ベビー・キッズ'],
        ];
        // dd($categories);
        $categories_id=array_column($categories,'id');
        $count = count($categories);
        $number = $this->faker->numberBetween(1,$count);
        $category_array = array_rand($categories_id,$number);
        // dd($category_array);
        return [
            'user_id'=> User::factory(),
            'name' => $this->faker->unique()->text(20),
            'pict_url' => $this->faker->url(),
            'brand_name' => $this->faker->name(),
            'price' => $this->faker->numberBetween(1000, 100000),
            'detail' => $this->faker->sentence(),
            'condition' => $this->faker->randomElement($statuses),
            'sold' => $this->faker->boolean(100),
            // 'categories' => $category_array,
        ];
    }
}
