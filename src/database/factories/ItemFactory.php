<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;
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
            'sold' => $this->faker->boolean(50),
        ];
    }

        public function configure()
    {
        return $this->afterCreating(function(Item $item){
            $item_id = $item -> id;
            // 画像の保存先を指定
            Storage::Fake('public');
            // ランダムな画像を生成
            $file = UploadedFile::fake()->image('test.jpg');
            // 拡張子を取得
            $filename = $file -> getClientOriginalExtension();
            // 擬似publicに保存
            $file->storeAs('/public','item'.$item_id.'.'.$filename);
            $item->pict_url='storage/item'.$item_id.'.'.$filename;
            $item->save();
        });
    }
    
}
