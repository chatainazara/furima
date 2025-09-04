<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Item $item){
            // ストレージを偽装（テスト用）
            Storage::fake('public');
            // ランダムな画像を生成して保存
            $file = UploadedFile::fake()->image('test.jpg');
            $filename = 'item'.$item->id.'.'.$file->getClientOriginalExtension();
            // 実際に保存するときは下記のコメントアウトを外す
            // $file->storeAs('public', $filename);
            // URL を設定
            $item->pict_url = 'storage/'.$filename;
            $item->save();
            // カテゴリをランダムで付与
            $count = Category::count();
            if($count > 0){
                $categories = Category::inRandomOrder()->take(rand(1, $count))->pluck('id');
                $item->categories()->attach($categories);
            }
        });
    }
}
