<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;

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
        $number_user = 1;
        User::factory($number_user)
        ->create();
        $this->artisan('db:seed', ['--class' => 'CategoriesTableSeeder']);
    }

    public function test_example()
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
        $items=Item::factory()->make();
        $categories = Category::all()->toArray();
        $items = array($categories,$items);
        // dd($items);
        $response = $this->post('/sell',[
            'items'=>$items,
        ]);
        // 登録を確認

    }
}

}
