<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;

class FavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::pluck('id')->all();
        $itemIds = Item::select('id','user_id')->get()->toArray();
        $mix=[];
        $id=1;
        foreach($userIds as $userId){
            foreach($itemIds as $itemId){
                if($userId !== $itemId['user_id']){
                $mix[] = ['id'=>$id,'user_id'=>$userId,'item_id'=>$itemId['id']];
                $id++;
                }
            }
        }
        $mixId = array_column($mix,'id');
        $count = count($mixId);
        $fakeId = $this->faker->unique()->numberBetween(1,$count);
        $key = array_search($fakeId, array_column($mix, "id"));
        $userId = $mix[$key]['user_id'];
        $itemId = $mix[$key]['item_id'];
        return [
            'user_id' => $userId,
            'item_id' => $itemId
        ];
    }
}
