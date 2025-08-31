<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\CategoriesTableSeeder;
use Symfony\Component\DomCrawler\Crawler;

class DestinationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

        use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        // 初期値として14個のカテゴリーを作成
        $this->seed(CategoriesTableSeeder::class);
        // ユーザー・商品・商品のカテゴリーリレーション・プロフィールを作成登録
        User::factory(2)
        ->has(Item::factory()
            ->count(1)
        )
        ->hasProfile()
        ->create();
    }

    public function test_destination_change()
    {
        $users = User::all();
        foreach ($users as $user){
            // 非認証状態を期待
            $this->assertGuest();
            // ログインデータの準備
            $login_data = [
            'name'=> $user['name'],
            'email' => $user['email'],
            'password' => 'password',
            ];
            // ログイン
            $response = $this->post('/login',$login_data);
            // 認証通過を期待
            $this->assertAuthenticated();
            // 自分以外が出品した商品を取得
            $items = Item::where('user_id','!=',$user->id)->get();
            // アイテムごと検証
            foreach($items as $item){
                $response = $this->get('/purchase/'.$item['id']);
                $response->assertViewIs('auth.buy');
                // お届け先を変更し購入画面を再度開く
                $response = $this->post('/purchase/address/'.$item['id'],[
                    'destination_post_code' => '999-9999',
                    'destination_address' => 'test_address',
                    'destination_building' => 'test_building',
                    'payment' => 'card',
                ]);
                // htmlを取得
                $html = $response->getContent();
                // 階層構造化
                $crawler = new Crawler($html);
                // お届け先を部分をブロック化
                $destination_block = $crawler->filter('.destination__content')->text();
                //先ほど変更した住所がお届け先として表示されていることを確認
                $expecting = ['999-9999','test_address','test_building'];
                foreach ($expecting as $word){
                    $this->assertStringContainsString($word, $destination_block);
                }
            }
        // ログアウト
        $response = $this->post('/logout');
        }
    }


public function test_destination_change_save()
    {
        $users = User::all();
        foreach ($users as $user){
            // 非認証状態を期待
            $this->assertGuest();
            // ログインデータの準備
            $login_data = [
            'name'=> $user['name'],
            'email' => $user['email'],
            'password' => 'password',
            ];
            // ログイン
            $response = $this->post('/login',$login_data);
            // 認証通過を期待
            $this->assertAuthenticated();
            // 自分以外が出品した商品を取得
            $items = Item::where('user_id','!=',$user->id)->get();
            // アイテムごと検証
            foreach($items as $item){
                $response = $this->get('/purchase/'.$item['id']);
                $response->assertViewIs('auth.buy');
                // お届け先を変更し購入画面を再度開く
                $response = $this->post('/purchase/address/'.$item['id'],[
                    'destination_post_code' => '999-9999',
                    'destination_address' => 'test_address',
                    'destination_building' => 'test_building',
                    'payment' => 'card',
                ]);
                // 購入ボタンを押す
                $response = $this->post('/purchase',[
                    'destination_post_code' => $response->viewData('destination_post_code'),
                    'destination_address' => $response->viewData('destination_address'),
                    'destination_building' => $response->viewData('destination_building'),
                    'payment' => $response->viewData('payment'),
                    'item_id' => $item->id,
                ]);
                // buysテーブルによってitem_idと紐づくことを確認
                $this->assertDatabaseHas('buys',[
                'item_id' => $item->id,
                'payment' => 'card',
                'destination_post_code' => '999-9999',
                'destination_address' => 'test_address',
                'destination_building' => 'test_building',
                ]);
            }
        // ログアウト
        $response = $this->post('/logout');
        }
    }
}

