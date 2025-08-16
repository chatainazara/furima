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
        $this->artisan('db:seed', ['--class' => 'CategoriesTableSeeder']);
        // $categories=Category::inRandomOrder()->take(3)->get();
        User::factory(1)->create()
        // ->has(Item::factory()->count(1),'items')
        ;

        // Item::factory($number)
        // $categories = Category::all();
        // dd($categories);
    }

    public function test_database_has()
    {
    // ログアウト状態を確認
    $this->assertGuest();
    // ログインする
    $users = User::all();
    // dd($users);
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
            $items=Item::factory()->make([
                'user_id'=> Auth::id(),
                'sold' => 0
            ]);

            $file = UploadedFile::fake()->image('test.jpeg');
            $categories=Category::inRandomOrder()->take(3)->get()->toArray();

            $response = $this->post('/sell',[
                'categories' => $categories,
                'condition'=> $items['condition'],
                'name'=>$items['name'],
                'brand_name'=>$items['brand_name'],
                'detail'=>$items['detail'],
                'price'=>$items['price'],
                'pict_url'=>$file,
            ]);

            // 登録を確認
            $this->assertDatabaseHas('items', [
                'user_id' => $items['user_id'],
                'pict_url' => $items['pict_url'],
                'condition' => $items['condition'],
                'name' => $items['name'],
                'brand_name' => $items['brand_name'],
                'detail' => $items['detail'],
                'price' => $items['price'],
                // 'sold' => $items['sold'],
                'sold' => 0,
            ]);
        }
    }

}
