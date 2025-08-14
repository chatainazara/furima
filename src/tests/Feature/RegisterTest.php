<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    public function test_user_name_validation()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // 名前を入力せずに他の必須項目を入力する
        $users = User::factory(10)->make();
        foreach($users as $user){
        $formData = [
            'name' => '',
            'email' => $user['email'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        // ボタンを押す
        $response = $this->post('/register', $formData);
        // バリデーションを期待
        $response->assertSessionHasErrors('name');
        $this->assertEquals('お名前を入力してください', session('errors')->first('name'));
        }
    }

    public function test_user_email_validation()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // メールアドレスを入力せずに他の必須項目を入力する
        $users = User::factory(10)->make();
        foreach($users as $user){
            $formData = [
                'name' => $user['name'],
                'email' => '',
                'password' => 'password',
                'password_confirmation' => 'password',
            ];
            // ボタンを押す
            $response = $this->post('/register', $formData);
            // バリデーションを期待
            $response->assertSessionHasErrors('email');
            $this->assertEquals('メールアドレスを入力してください', session('errors')->first('email'));
        }
    }

    public function test_user_password_empty_validation()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // パスワードを入力せずに他の必須項目を入力する
        $users = User::factory(10)->make();
        foreach($users as $user){
            $formData = [
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => '',
                'password_confirmation' => 'password',
            ];
            // ボタンを押す
            $response = $this->post('/register', $formData);
            // バリデーションを期待
            $response->assertSessionHasErrors('password');
            $this->assertEquals('パスワードを入力してください', session('errors')->first('password'));
        }
    }

    public function test_user_password_min8_validation()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // パスワードを８文字以下で入力する
        $users = User::factory(10)->make();
        foreach($users as $user){
            $formData = [
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => 'pass',
                'password_confirmation' => 'pass',
            ];
            // ボタンを押す
            $response = $this->post('/register', $formData);
            // バリデーションを期待
            $response->assertSessionHasErrors('password');
            $this->assertEquals('パスワードは８文字以上で入力してください', session('errors')->first('password'));
        }
    }

    public function test_user_password_confirm_validation()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // パスワードと異なる確認パスワードを入力する
        $users = User::factory(10)->make();
        foreach($users as $user){
            $formData = [
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => 'password',
                'password_confirmation' => 'notpassword',
            ];
            // ボタンを押す
            $response = $this->post('/register', $formData);
            // バリデーションを期待
            $response->assertSessionHasErrors('password');
            $this->assertEquals('パスワードと一致しません', session('errors')->first('password'));
        }
    }

        public function test_user_can_register()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // メールアドレスを入力せずに他の必須項目を入力する
        $users = User::factory(10)->make();
        foreach($users as $user){
            $formData = [
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => 'password',
                'password_confirmation' => 'password',
            ];
            // ボタンを押す
            $response = $this->post('/register', $formData);
            // 認証の通過を期待
            $this->assertAuthenticated();
            // プロフィール設定画面への遷移を期待
            $response->assertRedirect('mypage/profile');
            $response = $this->get('mypage/profile');
            $response->assertViewIs('auth.profile_edit');
            $response->assertSee('プロフィール設定');
            // 会員情報の登録を期待
            $this->assertDatabaseHas('users', [
                'name' => $user['name'],
                'email' => $user['email'],
            ]);
            $registed_user = User::Where('email',$user['email'])->first();
            $this->assertTrue(Hash::check('password', $registed_user->password));
            $response = $this->post('/logout');
            $response = $this->get('/register');
        }
    }
}
