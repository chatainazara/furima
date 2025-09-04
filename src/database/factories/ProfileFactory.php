<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
            'pict_url' => '',
            'post_code' => $this->faker->regexify('[1-9]{3}-[0-9]{4}'),
            'address' => $this->faker->address(),
            'building' => $this->faker->secondaryAddress(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Profile $profile){
            $profile_id = $profile -> id;
            // 画像の保存先を指定
            Storage::Fake('public');
            // ランダムな画像を生成
            $file = UploadedFile::fake()->image('test.jpg');
            // 拡張子入りファイル名を作成
            $filename = 'profile'.$profile->id.'.'.$file->getClientOriginalExtension();
            // 実際に保存するときは下記のコメントアウトを外す
            // $file->storeAs('public', $filename);
            // pict_urlを更新
            $profile->pict_url='storage/profile'.$filename;
            $profile->save();
        });
    }

}
