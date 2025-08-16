<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Item;

class CategoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $items = Item::all->toArray();
        $categories = Category::all()->toArray();
        // $categories_id=array_column($categories,'id');
        $id=1;
        foreach ($items as $item){
            foreach($categories as $category){
                $mixes[] = ['id'=>$id,'item'=>$item['id'] ,'categories'=>$category['id']];
                $id++;
            }
        }
        $count = count($mixes);
        $number = $this->faker->unique()->numberBetween(1,$count);
        // $category_array = array_rand($categories_id,$number);
        $itemid = $mix[$number]['item_id'];
        $userid = $mix[$number]['category_id'];
        return [
            'item_id' => Auth::id(),
            'category_id'
        ];
    }
}
