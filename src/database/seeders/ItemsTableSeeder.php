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
            'pict_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'brand_name' => 'Rolax',
            'price' => 15000,
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition' => '良好',
            'sold_condition' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 1,
            'name' => 'HDD',
            'pict_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'brand_name' => '西芝',
            'price' => 5000,
            'detail' => '高で信頼性の高いハードディスク',
            'condition' => '目立った傷や汚れなし',
            'sold_condition' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 2,
            'name' => '玉ねぎ3束',
            'pict_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'brand_name' => 'なし',
            'price' => 300,
            'detail' => '新鮮な玉ねぎ 3束のセット',
            'condition' => 'やや傷や汚れあり',
            'sold_condition' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 3,
            'name' => '革靴',
            'pict_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'brand_name' => '',
            'price' => 4000,
            'detail' => 'クラシックなデザインの革靴',
            'condition' => '状態が悪い',
            'sold_condition' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 1,
            'name' => 'ノートPC',
            'pict_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'brand_name' => '',
            'price' => 45000,
            'detail' => '高性能なノートパソコン',
            'condition' => '良好',
            'sold_condition' => 1,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 1,
            'name' => 'マイク',
            'pict_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'brand_name' => 'なし',
            'price' => 8000,
            'detail' => '高音質のレコーディング用マイク',
            'condition' => '目立った傷や汚れなし',
            'sold_condition' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 3,
            'name' => 'ショルダーバッグ',
            'pict_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'brand_name' => '',
            'price' => 3500,
            'detail' => 'おしゃれなショルダーバッグ',
            'condition' => 'やや傷や汚れあり',
            'sold_condition' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 3,
            'name' => 'タンブラー',
            'pict_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'brand_name' => 'なし',
            'price' => 500,
            'detail' => '使いやすいタンブラー',
            'condition' => '状態が悪い',
            'sold_condition' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 3,
            'name' => 'コーヒーミル',
            'pict_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'brand_name' => 'Starbacks',
            'price' => 4000,
            'detail' => '手動のコーヒーミル',
            'condition' => '良好',
            'sold_condition' => 0,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => 4,
            'name' => 'メイクセット',
            'pict_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'brand_name' => '',
            'price' => 2500,
            'detail' => '便利なメイクアップセット',
            'condition' => '目立った傷や汚れなし',
            'sold_condition' => 0,
        ];
        DB::table('items')->insert($param);
    }
}
