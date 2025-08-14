<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'レンゲ',
            'email' => 'renge@sakamaki-forest.com',
            'password' => Hash::make('rengerenge'),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'エンジュ',
            'email' => 'enju@sakamaki-forest.com',
            'password' => Hash::make('enjuenju'),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'オウレン',
            'email' => 'ouren@sakamaki-forest.com',
            'password' => Hash::make('ourenouren'),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'バンクス',
            'email' => 'banks@sakamaki-forest.com',
            'password' => Hash::make('banksbanks'),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テーダ',
            'email' => 'teda@sakamaki-forest.com',
            'password' => Hash::make('tedateda'),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'リキッダ',
            'email' => 'rikida@sakamaki-forest.com',
            'password' => Hash::make('rikidarikida'),
        ];
        DB::table('users')->insert($param);
    }
}
