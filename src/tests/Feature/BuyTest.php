<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Comment;
use Database\Seeders\CategoriesTableSeeder;

class BuyTest extends TestCase
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

    public function test_buy_action()
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
                $response = $this->post('/purchase',[
                    'destination_post_code' => $user->profile->post_code,
                    'destination_address' => $user->profile->address,
                    'destination_building' => $user->profile->building,
                    'payment' => 'convenience',
                    'item_id' => $item->id,
                ]);
                $this->assertDatabaseHas('buys',[
                'item_id' => $item->id,
                ]);
            }
        // ログアウト
        $response = $this->post('/logout');
        }
    }

    public function test_buy_view_sold()
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
                $response = $this->post('/purchase',[
                    'destination_post_code' => $user->profile->post_code,
                    'destination_address' => $user->profile->address,
                    'destination_building' => $user->profile->building,
                    'payment' => 'convenience',
                    'item_id' => $item->id,
                ]);
                $response = $this->get('/');
                $response->assertSee('sold');
            }
        // ログアウト
        $response = $this->post('/logout');
        }
    }

    public function test_buy_view_mypage()
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
                $response = $this->post('/purchase',[
                    'destination_post_code' => $user->profile->post_code,
                    'destination_address' => $user->profile->address,
                    'destination_building' => $user->profile->building,
                    'payment' => 'convenience',
                    'item_id' => $item->id,
                ]);
                $response = $this->post('/mypage?tab=buy',[
                    'search' => '',
                ]);
                $response->assertSee($item->name);
            }
        // ログアウト
        $response = $this->post('/logout');
        }
    }

}
