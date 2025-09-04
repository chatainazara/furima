<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;
// use App\Models\Item;
// use Database\Factories\ItemFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(BuysTableSeeder::class);
        $this->call(CategoryItemTableSeeder::class);
    }
}
