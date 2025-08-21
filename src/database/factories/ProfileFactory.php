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
            'building'=>$this->faker->secondaryAddress(),
            'destination_post_code' => $this->faker->regexify('[1-9]{3}-[0-9]{4}'),
            'destination_address' => $this->faker->address(),
            'destination_building'=>$this->faker->secondaryAddress(),
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
            // 拡張子を取得
            $filename = $file -> getClientOriginalExtension();
            // 擬似publicに保存
            $file->storeAs('/public','profile'.$profile_id.'.'.$filename);
            $profile->pict_url='storage/profile'.$profile_id.'.'.$filename;
            $profile->save();
        });
    }

}
