<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
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
            'pict_url' => '',
            'post_code' => '000-0000',
            'address' => '北海道千歳町0-0-0',
            'building' => '蓮花ハイツC棟302',
            'destination_post_code' => '000-0000',
            'destination_address' => '北海道千歳町0-0-0',
            'destination_building' => '蓮花ハイツC棟302',
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => 2,
            'pict_url' => '',
            'post_code' => '000-0000',
            'address' => '北海道由仁市0-0-0',
            'building' => 'グリーンエンジュA-202',
            'destination_post_code' => '000-0000',
            'destination_address' => '北海道由仁市0-0-0',
            'destination_building' => 'グリーンエンジュA-202',
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => 3,
            'pict_url' => '',
            'post_code' => '000-0000',
            'address' => '北海道神居町0-0-0',
            'building' => 'オウレン荘105',
            'destination_post_code' => '000-0000',
            'destination_address' => '北海道神居町0-0-0',
            'destination_building' => 'オウレン荘105',
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => 4,
            'pict_url' => '',
            'post_code' => '000-0000',
            'address' => '北海道新篠津市0-0-0',
            'building' => 'バンクスタワー407',
            'destination_post_code' => '000-0000',
            'destination_address' => '北海道新篠津市0-0-0',
            'destination_building' => 'バンクスタワー407',
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => 5,
            'pict_url' => '',
            'post_code' => '000-0000',
            'address' => '北海道音威子府区0-0-0',
            'building' => 'テーダスクエア231',
            'destination_post_code' => '000-0000',
            'destination_address' => '北海道音威子府区0-0-0',
            'destination_building' => 'テーダスクエア231',
        ];
        DB::table('profiles')->insert($param);
            $param = [
            'user_id' => 6,
            'pict_url' => '',
            'post_code' => '000-0000',
            'address' => '北海道国縫市0-0-0',
            'building' => 'リキッダセンター206',
            'destination_post_code' => '000-0000',
            'destination_address' => '北海道国縫市0-0-0',
            'destination_building' => 'リキッダセンター206',
        ];
        DB::table('profiles')->insert($param);
    }
}
