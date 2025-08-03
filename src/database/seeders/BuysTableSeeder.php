<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_id' => 5,
            'user_id' => 3,
            'payment' => 'カード支払い',
        ];
        DB::table('buys')->insert($param);
    }
}
