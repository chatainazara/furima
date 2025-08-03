<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_name_validation()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // 名前を入力せずに他の必須項目を入力する
        $formData = [
            'name' => '',
            'email' => 'sirakaba@sakamaki-forest.com',
            'password' => 'sirakabasirakaba',
            'password_confirmation' => 'sirakabasirakaba',
        ];
        // ボタンを押す
        $response = $this->post('/register', $formData);
        // バリデーションを期待
        $response->assertSessionHasErrors('name');
        $this->assertEquals('お名前を入力してください', session('errors')->first('name'));
    }

    public function test_user_email_validation()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // メールアドレスを入力せずに他の必須項目を入力する
        $formData = [
            'name' => 'sirakaba',
            'email' => '',
            'password' => 'sirakabasirakaba',
            'password_confirmation' => 'sirakabasirakaba',
        ];
        // ボタンを押す
        $response = $this->post('/register', $formData);
        // バリデーションを期待
        $response->assertSessionHasErrors('email');
        $this->assertEquals('メールアドレスを入力してください', session('errors')->first('email'));
    }

    public function test_user_password_empty_validation()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // メールアドレスを入力せずに他の必須項目を入力する
        $formData = [
            'name' => 'sirakaba',
            'email' => 'sirakaba@sakamaki-forest.com',
            'password' => '',
            'password_confirmation' => 'sirakabasirakaba',
        ];
        // ボタンを押す
        $response = $this->post('/register', $formData);
        // バリデーションを期待
        $response->assertSessionHasErrors('password');
        $this->assertEquals('パスワードを入力してください', session('errors')->first('password'));
    }

    public function test_user_password_min8_validation()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // メールアドレスを入力せずに他の必須項目を入力する
        $formData = [
            'name' => 'sirakaba',
            'email' => 'sirakaba@sakamaki-forest.com',
            'password' => 'siraka',
            'password_confirmation' => 'siraka',
        ];
        // ボタンを押す
        $response = $this->post('/register', $formData);
        // バリデーションを期待
        $response->assertSessionHasErrors('password');
        $this->assertEquals('パスワードは８文字以上で入力してください', session('errors')->first('password'));
    }

    public function test_user_password_confirm_validation()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // メールアドレスを入力せずに他の必須項目を入力する
        $formData = [
            'name' => 'sirakaba',
            'email' => 'sirakaba@sakamaki-forest.com',
            'password' => 'siraka',
            'password_confirmation' => 'sirakab',
        ];
        // ボタンを押す
        $response = $this->post('/register', $formData);
        // バリデーションを期待
        $response->assertSessionHasErrors('password');
        $this->assertEquals('パスワードと一致しません', session('errors')->first('password'));
    }

        public function test_user_can_register()
    {
        // 会員登録ページを開く
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // メールアドレスを入力せずに他の必須項目を入力する
        $formData = [
            'name' => 'sirakaba',
            'email' => 'sirakaba@sakamaki-forest.com',
            'password' => 'sirakabasirakaba',
            'password_confirmation' => 'sirakabasirakaba',
        ];
        // ボタンを押す
        $response = $this->post('/register', $formData);
        // 認証の通過を期待
        $this->assertAuthenticated();
        // プロフィール設定画面への遷移を期待
        $response->assertRedirect('mypage/profile');
        // 会員情報の登録を期待
        $this->assertDatabaseHas('users', [
            'name' => 'sirakaba',
            'email' => 'sirakaba@sakamaki-forest.com',
        ]);
        $registed_user = User::Where('name','sirakaba')->first();
        $this->assertTrue(Hash::check('sirakabasirakaba', $registed_user->password));
    }
}
