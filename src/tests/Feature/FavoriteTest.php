<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Profile;
use Symfony\Component\DomCrawler\Crawler;
use Database\Seeders\CategoriesTableSeeder;

class FavoriteTest extends TestCase
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

        $this->seed(CategoriesTableSeeder::class);
        $count=Category::count();
        User::factory(2)
        ->has(Item::factory()
            ->count(4)
            )
        ->hasProfile()
        ->create();
    }

    public function test_favorite_push()
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
            // 全アイテムを取得
            $items = Item::all();
            // アイテムごと検証
            foreach($items as $item){
                $response = $this->get('/item/'.$item['id']);
                $response->assertViewIs('item_detail');
                // いいねを押す
                $response = $this->post('/item/'.$item['id'],['action' => 'favorite']);
                // 保存されていることの確認
                $this->assertDatabaseHas('favorites',[
                    'item_id' => $item['id'],
                    'user_id' => $user['id']
                ]);
                // htmlを取得
                $html = $response->getContent();
                // 階層構造化
                $crawler = new Crawler($html);
                // いいねブロックを作成（コメントも同様のブロックだが本テストではコメントは0）
                $favorite_block = $crawler->filter('.content__react-count')->text();
                $count = Favorite::where('item_id',$item['id'])->count();
                // お気に入りの数が反映されることを期待
                $this->assertStringContainsString($count, $favorite_block);
                // 塗りつぶしの星が見える
                $response->assertSee('img/_i_icon_14621_icon_146210.svg');
                // 中抜きの星が見えない
                $response->assertDontSee('img/_i_icon_14623_icon_146230.svg');
                // もう一度いいねを押す
                $response = $this->post('/item/'.$item['id'],['action' => 'un_favorite']);
                // htmlを取得
                $html = $response->getContent();
                // 階層構造化
                $crawler = new Crawler($html);
                // いいねブロックを作成（コメントも同様のブロックだが本テストではコメントは0）
                $favorite_block = $crawler->filter('.content__react-count')->text();
                // いいねの数が１減少することを期待
                $this->assertStringContainsString($count-1, $favorite_block);
            }
            // ログアウト
            $response = $this->post('/logout');
        }
    }
}
