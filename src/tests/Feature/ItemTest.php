<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Item;

class ItemTest extends TestCase
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
        User::factory(10)
        ->hasItems(5)
        ->create();
    }

    public function test_all_item_visible()
    {
        $items = Item::All();
        $this->assertDatabaseCount('items', 50);
        $response = $this->get('/');
        $response->assertStatus(200);
        foreach ($items as $item) {
            $response->assertSeeText($item->name);
        }
    }

    public function test_sold_label_visible()
    {
        $response = $this->get('/');
        $response->assertSeeText('sold');
    }

    public function test_sold_item_unvisible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $users = User::all();
        foreach ($users as $user){
            $loginData=[
                'email'=> $user['email'],
                'password'=> 'password',
            ];
            $response = $this->post('/login', $loginData);
            $this->assertAuthenticated();
            // $userの出品したもののid取得
            $response = $this->get('/');
            $remove_items = Item::where('user_id',Auth::id())->get();
            // 自分が出品したものが画面上に出ていないかを確認
            foreach ($remove_items as $item) {
            $response->assertViewIs('index');
            $response->assertDontSeeText($item['name']);
            }
        }
    }

}
