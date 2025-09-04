<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\CategoriesTableSeeder;
use Illuminate\Support\Facades\Session;
use Stripe\PaymentIntent;
use Mockery;

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
        Session::flush();
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

    public function test_card_and_konbini_payment()
    {
        // ユーザーと商品を準備
        $users = User::all();
        foreach($users as $user){
            $items = Item::where('user_id','!=',$user->id)->get();
            foreach($items as $item){
                // Stripe static create をモック（カード払い用）
                $cardMock = Mockery::mock('overload:' . PaymentIntent::class);
                $cardMock->shouldReceive('create')
                        ->once()
                        ->andReturn((object)['id' => 'pi_card_test_123']);
                // ログインと同時にセッションを保存
                $this->actingAs($user)
                    ->withSession([
                        'user_id' => $user->id,
                        'item_id' => $item->id,
                        'payment' => 'card',
                        'destination_post_code' => $user->profile->post_code,
                        'destination_address' => $user->profile->address,
                        'destination_building' => $user->profile->building,
                    ]);
                // 商品購入画面を開く
                $response = $this->get('/purchase/'.$item->id);
                $response->assertViewIs('auth.purchase');
                // 購入ボタンを押下
                $response = $this->postJson('/payment/store', [
                    'payment_method' => 'pm_card_test_123',
                ]);
                $response->assertStatus(200)
                        ->assertJson(['success' => true]);
                // 購入が完了を確認
                $this->assertDatabaseHas('buys', [
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'payment' => 'card',
                ]);

                // --- コンビニ払い ---
                $konbiniMock = Mockery::mock('overload:' . PaymentIntent::class);
                $konbiniMock->shouldReceive('create')
                            ->once()
                            ->andReturn((object)['id' => 'pi_konbini_test_123']);
                $this->withSession([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'payment' => 'konbini',
                    'destination_post_code' => $user->profile->post_code,
                    'destination_address' => $user->profile->address,
                    'destination_building' => $user->profile->building,
                ]);
                // 商品購入画面を開く
                $response = $this->get('/purchase/'.$item->id);
                $response->assertViewIs('auth.purchase');
                // 購入ボタンを押下
                $response = $this->postJson('/payment/store', [
                    // コンビニ払いは payment_method 不要
                ]);
                $response->assertStatus(200)
                        ->assertJson(['success' => true]);
                // 購入完了を確認
                $this->assertDatabaseHas('buys', [
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'payment' => 'konbini',
                ]);
            }
        }
    }

    public function test_buy_view_sold()
    {
        // buysテーブルに保存されることは上記で確認済みなのでカード払いの1件目でsoldが出ることを確認
        // ホームの中にsoldはない
        $response = $this->get('/');
        $response->assertDontSee('sold');
        // ユーザーと商品を準備
        $user = User::first();
        $item = Item::where('user_id','!=',$user->id)->first();
        // Stripe static create をモック（カード払い用）
        $cardMock = Mockery::mock('overload:' . PaymentIntent::class);
        $cardMock->shouldReceive('create')
                ->andReturn((object)['id' => 'pi_card_test_123']);
        // ログインしてセッションを保存
        $this->actingAs($user)
            ->withSession([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment' => 'card',
                'destination_post_code' => $user->profile->post_code,
                'destination_address' => $user->profile->address,
                'destination_building' => $user->profile->building,
            ]);
        // 商品購入画面を開く
        $response = $this->get('/purchase/'.$item->id);
        $response->assertViewIs('auth.purchase');
        // 購入ボタンを押下
        $response = $this->postJson('/payment/store', [
            'payment_method' => 'pm_card_test_123',
        ]);
        // ホームの中にsoldがある
        $response = $this->get('/');
        $response->assertSee('sold');
    }

    public function test_buy_view_mypage()
    {
        // ユーザーと商品を準備
        $user = User::first();
        $item = Item::where('user_id','!=',$user->id)->first();
        $items = Item::all()->pluck('name')->toArray();
        // $userを認証状態へ
        $this->actingAs($user);
        // マイページにアクセス
        $response = $this->post('/mypage?tab=buy');
        // 購入済み商品に全ての商品名が表示されない
        $response->assertDontSee($items);
        // Stripe static create をモック（カード払い用）
        $cardMock = Mockery::mock('overload:' . PaymentIntent::class);
        $cardMock->shouldReceive('create')
                ->andReturn((object)['id' => 'pi_card_test_123']);
        // セッションを保存
        $this->actingAs($user)
            ->withSession([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment' => 'card',
                'destination_post_code' => $user->profile->post_code,
                'destination_address' => $user->profile->address,
                'destination_building' => $user->profile->building,
            ]);
        // 商品購入画面を開く
        $response = $this->get('/purchase/'.$item->id);
        $response->assertViewIs('auth.purchase');
        // 購入ボタンを押下
        $response = $this->postJson('/payment/store', [
            'payment_method' => 'pm_card_test_123',
        ]);
        // プロフィールの購入した商品に移動
        $response = $this->post('/mypage?tab=buy');
        // 購入した商品の商品名が記載されている
        $response->assertSee($item->name);
    }
}
