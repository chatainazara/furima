<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class MylistTest extends TestCase
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
        $number_user = 10;
        $number_item = 5;
        User::factory($number_user)
        ->hasItems($number_item)
        ->create();
        Favorite::factory(round($number_user*$number_user*$number_item/10)+1)
        ->create();
    }


    public function test_favorite(){
        $this->assertDatabaseCount('favorites', 51);
    }

    public function test_favorite_item_visible(){
        $select_users = Favorite::distinct()->pluck('user_id')->toArray();
        $users = User::whereIn('id',$select_users)->get();
        foreach($users as $user){
            // logout状態を期待
            $this->assertGuest();
            // 全ての必要項目を入力
            $loginData= [
                'email' => $user['email'],
                'password' => 'password',
            ];
            // ログインボタンを押す
            $response = $this->post('/login',$loginData);
            // 認証通過を期待
            $this->assertAuthenticated();
            // indexページへの移行('/')を期待
            $response->assertRedirect('/');
            // マイリストへ遷移
            $response = $this->post('/?tab=mylist');
            $response->assertViewIs('index');
            $response->assertViewHas('items');
            // 現在の認証idにかかるお気に入り情報を取得
            $favorites = Favorite::where('user_id',Auth::id())->get();
            // $favorites_count = Favorite::where('user_id',Auth::id())->count();
            // お気に入り情報の一つずつを確認
            foreach ($favorites as $favorite){
                // お気に入り情報のitem_idに紐づくitemsテーブルの要素の名前を取得
                $item_name = Item::where('id',$favorite['item_id'])->first()->name;
                // 画面上にいいねした商品の表示があることを期待
                $response->assertSeeText($item_name);
            }
            // 現在のユーザーがいいねをしていない商品を取得
            $nofavorites = Item::whereNotIn('id',$favorites->pluck('item_id'))->get();
            // その商品が一つずつ画面に見えていないかを確認
            foreach($nofavorites as $nofavorite){
                $response->assertDontSeeText($nofavorite['name']);
            }
        // logoutボタンを押下
        $response = $this->post('/logout');
        //logoutを期待
        $this->assertGuest();
        }
    }

    public function test_mylist_sold_visible(){
        $select_users = Favorite::distinct()->pluck('user_id')->toArray();
        $users = User::whereIn('id',$select_users)->get();
        foreach($users as $user){
            // logout状態を期待
            $this->assertGuest();
            // 全ての必要項目を入力
            $loginData= [
                'email' => $user['email'],
                'password' => 'password',
            ];
            // ログインボタンを押す
            $response = $this->post('/login',$loginData);
            // 認証通過を期待
            $this->assertAuthenticated();
            // indexページへの移行('/')を期待
            $response->assertRedirect('/');
            // マイリストへ遷移
            $response = $this->post('/?tab=mylist');
            // 表示画面にsoldが存在することを確認（factoryにより全商品がsoldに設定されている）
            $response->assertSeeText('sold');
            // logoutボタンを押下
            $response = $this->post('/logout');
            //logoutを期待
            $this->assertGuest();
        }
    }

    public function test_guest_mylist_unvisible(){
        $items = Item::all();
        // logout状態を期待
        $this->assertGuest();
        // logout状態で/にgetでアクセス
        $response = $this -> get('/');
        // indexが表示されることを確認
        $response->assertViewIs('index');
        // マイリストへ遷移
        $response = $this->post('/?tab=mylist');
        // 何も表示されないことを期待（商品名が一つも表示されないことで確認）
        foreach ($items as $item){
            $response->assertDontSeeText($item['name']);
        }
    }
}