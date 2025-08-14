<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'name' => '腕時計',
            'pict_url' => 'storage/item1.jpeg',
            'brand_name' => 'Rolax',
            'price' => 15000,
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition' => '良好',
            'sold' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 1,
            'name' => 'HDD',
            'pict_url' => 'storage/item2.jpeg',
            'brand_name' => '西芝',
            'price' => 5000,
            'detail' => '高で信頼性の高いハードディスク',
            'condition' => '目立った傷や汚れなし',
            'sold' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 2,
            'name' => '玉ねぎ3束',
            'pict_url' => 'storage/item3.jpeg',
            'brand_name' => 'なし',
            'price' => 300,
            'detail' => '新鮮な玉ねぎ 3束のセット',
            'condition' => 'やや傷や汚れあり',
            'sold' => 1,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 3,
            'name' => '革靴',
            'pict_url' => 'storage/item4.jpeg',
            'brand_name' => '',
            'price' => 4000,
            'detail' => 'クラシックなデザインの革靴',
            'condition' => '状態が悪い',
            'sold' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 1,
            'name' => 'ノートPC',
            'pict_url' => 'storage/item5.jpeg',
            'brand_name' => '',
            'price' => 45000,
            'detail' => '高性能なノートパソコン',
            'condition' => '良好',
            'sold' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 1,
            'name' => 'マイク',
            'pict_url' => 'storage/item6.jpeg',
            'brand_name' => 'なし',
            'price' => 8000,
            'detail' => '高音質のレコーディング用マイク',
            'condition' => '目立った傷や汚れなし',
            'sold' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 3,
            'name' => 'ショルダーバッグ',
            'pict_url' => 'storage/item7.jpeg',
            'brand_name' => '',
            'price' => 3500,
            'detail' => 'おしゃれなショルダーバッグ',
            'condition' => 'やや傷や汚れあり',
            'sold' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 3,
            'name' => 'タンブラー',
            'pict_url' => 'storage/item8.jpeg',
            'brand_name' => 'なし',
            'price' => 500,
            'detail' => '使いやすいタンブラー',
            'condition' => '状態が悪い',
            'sold' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 3,
            'name' => 'コーヒーミル',
            'pict_url' => 'storage/item9.jpeg',
            'brand_name' => 'Starbacks',
            'price' => 4000,
            'detail' => '手動のコーヒーミル',
            'condition' => '良好',
            'sold' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 4,
            'name' => 'メイクセット',
            'pict_url' => 'storage/item10.jpeg',
            'brand_name' => '',
            'price' => 2500,
            'detail' => '便利なメイクアップセット',
            'condition' => '目立った傷や汚れなし',
            'sold' => 0,
        ];
        DB::table('items')->insert($param);
    }
}
