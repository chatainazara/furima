<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Profile;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Arr;

class ProfileEditTest extends TestCase
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
        ->has(Profile::factory())
        ->create();
    }

    public function test_old_value_visible()
    {
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
            // プロフィール編集画面にアクセス
            $response = $this->get('/mypage/profile');
            // プロフィール画面の表示を確認
            $response->assertViewIs('auth.profile_edit');
            $profile = Profile::where('user_id',$user['id'])->first();
            // 以下が表示されていることを確認
            $response->assertSee($profile['pict_url']);
            $response->assertSee($user['name']);
            $response->assertSee($profile['post_code']);
            $response->assertSee($profile['address']);
            // ログアウト
            $response = $this->post('/logout');
        }
    }
}
