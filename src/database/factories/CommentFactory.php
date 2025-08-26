<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\User;
use App\Models\Item;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_ids = User::pluck('id')->all();
        $item_ids = Item::select('id','user_id')->get()->toArray();
        $id=1;
        foreach($user_ids as $user_id){
            foreach($item_ids as $item_id){
                $mix[] = ['id'=>$id,'user_id'=>$user_id,'item_id'=>$item_id['id']];
                $id++;
            }
        }
        $count = count($mix);
        $fake_id = $this->faker->numberBetween(1,$count);
        $key = array_search($fake_id, array_column($mix, "id"));
        $userid = $mix[$key]['user_id'];
        $itemid = $mix[$key]['item_id'];

        return [
            'user_id' => $userid,
            'item_id' => $itemid,
            'content' => $this->faker->sentence(),
        ];
    }
}
