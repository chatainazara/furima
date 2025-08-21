<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SellTest extends TestCase
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
        $user_number = 2;
        $this->artisan('db:seed', ['--class' => 'CategoriesTableSeeder']);
        User::factory($user_number)->create();
    }

    public function test_database_has()
    {
        // 一人づつ出品する商品数
        $item_number = 3;
        // ログアウト状態を確認
        $this->assertGuest();
        // ログインする
        $users = User::all();
        // ユーザー一人ずつ検証
        foreach($users as $user){
            $loginData= [
                'email' => $user->email,
                'password' => 'password',
                ];
            // ログインボタンを押す
            $response = $this->post('/login',$loginData);
            // 認証通過を期待
            $this->assertAuthenticated();
            // 出品画面に移行
            $response = $this->get('/sell');
            $response->assertViewIs('auth.sell');
            // 出品内容をコントローラーにポスト
            $items=Item::factory($item_number)->make([
                'user_id'=> Auth::id(),
                'sold' => 0
            ]);
            // 商品ひとつずつ検証
            foreach($items as $item){
                // 出品データの作成
                $count=count(Category::all());
                $categories=Category::inRandomOrder()->take(rand(1,$count))->pluck('id')->toArray();
                // 画像の保存先を指定
                Storage::Fake('public');
                // 画像データを生成
                $file = UploadedFile::fake()->image('test.jpg');
                // データをポスト送信
                $data = [
                    'categories' => $categories,
                    'condition' => $item['condition'],
                    'name' => $item['name'],
                    'brand_name' => $item['brand_name'],
                    'detail' => $item['detail'],
                    'price' => $item['price'],
                    'pict_url' => $file,
                    // 'pict_url' => $item['pict_url']
                ];
                $response = $this->post('/sell',$data);
                // 登録したデータのidを取得
                $newid = Item::max('id');
                // アップロードしたファイルの拡張子
                $fileName = $file -> getClientOriginalExtension();
                // 期待される画像のパス
                $path = 'storage/item'.$newid.'.'.$fileName;
                // 商品情報の登録を期待
                $this->assertDatabaseHas('items', [
                    'user_id' => $item['user_id'],
                    'pict_url' => $path,
                    'condition' => $item['condition'],
                    'name' => $item['name'],
                    'brand_name' => $item['brand_name'],
                    'detail' => $item['detail'],
                    'price' => $item['price'],
                    'sold' => 0,
                ]);
                // カテゴリーの登録を期待
                foreach($categories as $category){
                    $this->assertDatabaseHas('category_item', [
                        'category_id' => $category,
                        'item_id' => $newid,
                    ]);
                }
            }
        }
    }
}
