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
            // ログイン
            $this->actingAs($user);
            // 自分以外が出品した商品を取得
            $items = Item::where('user_id','!=',$user->id)->get();
            // アイテムごと検証
            foreach($items as $item){
                // 購入ページにアクセス
                $response = $this->get('/purchase/'.$item->id);

            // カード払いを指定
                $response = $this->post('/purchase/address/'.$item->id,[
                    'destination_post_code' => $user->profile->post_code,
                    'destination_address' => $user->profile->address,
                    'destination_building' => $user->profile->building,
                    'payment' => 'card',
                ]);
                // htmlを取得
                $html = $response->getContent();
                // 階層構造化
                $crawler = new Crawler($html);
                // 承継画面部分をブロック化
                $payment_block = $crawler->filter('.confirm')->text();
                // カード払いが存在することを確認
                $this->assertStringContainsString('カード払い', $payment_block);
                // コンビニ払いが存在しないことを確認
                $this->assertStringNotContainsString('コンビニ払い', $payment_block);

            // コンビニ払いを指定
                $response = $this->post('/purchase/address/'.$item->id,[
                    'destination_post_code' => $user->profile->post_code,
                    'destination_address' => $user->profile->address,
                    'destination_building' => $user->profile->building,
                    'payment' => 'konbini',
                ]);
                // htmlを取得
                $html = $response->getContent();
                // 階層構造化
                $crawler = new Crawler($html);
                // 承継画面部分をブロック化
                $payment_block = $crawler->filter('.confirm')->text();
                // カード払いが存在することを確認
                $this->assertStringContainsString('コンビニ払い', $payment_block);
                // カード払いが存在しないことを確認
                $this->assertStringNotContainsString('カード払い', $payment_block);
            }
        // ログアウト
        $response = $this->post('/logout');
        }
    }
}
