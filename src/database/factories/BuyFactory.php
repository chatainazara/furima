<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;

class BuyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $mix=[];
        // $id=1;
        // $items = Item::all();
        // foreach($items as $item){
        //     $users = User::where('id','!=',$item->user_id)->get();
        //     $mix[] = [
        //         'id' => $id,
        //         'item_id' => $item->id,
        //         'user_id' => $users->random()->id,
        //     ];
        //     $id++;
        // }


        // $fake_id = $this->faker->unique()->numberBetween(1,Item::count());
        // $key = array_search($fake_id, array_column($mix, "id"));
        // $user_id = $mix[$key]['user_id'];
        // $item_id = $mix[$key]['item_id'];

        // Itemのidリストをuniqueで使う
        $item_id = $this->faker->unique()->randomElement(Item::pluck('id')->toArray());

        // アイテムを取得
        $item = Item::find($item_id);

        // そのアイテムの持ち主以外のユーザーをランダムに取得
        $user = User::where('id', '!=', $item->user_id)
                    ->inRandomOrder()
                    ->first();


        $statuses = ['card', 'convenience'];

        return [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment' => $this->faker->randomElement($statuses),
            'destination_post_code' => $this->faker->regexify('[1-9]{3}-[0-9]{4}'),
            'destination_address' => $this->faker->address(),
            'destination_building' => $this->faker->secondaryAddress(),
        ];
    }
}
