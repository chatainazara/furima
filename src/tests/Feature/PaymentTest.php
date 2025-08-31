<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\CategoriesTableSeeder;
use Symfony\Component\DomCrawler\Crawler;

class PaymentTest extends TestCase
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

    public function test_payment_change()
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
                $response = $this->post('/purchase/address/'.$item['id'],[
                    'destination_post_code' => $user->profile->post_code,
                    'destination_address' => $user->profile->address,
                    'destination_building' => $user->profile->building,
                    'payment' => 'card',
                ]);
                // htmlを取得
                $html = $response->getContent();
                // 階層構造化
                $crawler = new Crawler($html);
                // 支払い方法部分をブロック化
                $payment_block = $crawler->filter('.confirm')->text();
                // カード払いが存在することを確認
                $this->assertStringContainsString('カード払い', $payment_block);
            }
        // ログアウト
        $response = $this->post('/logout');
        }
    }
}
