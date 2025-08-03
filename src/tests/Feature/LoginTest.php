<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_email_validation()
    {
        // ログインページを開く
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // メールアドレスを入力せずに他の必須項目を入力する
        $formData = [
            'email' => '',
            'password' => 'sirakabasirakaba',
        ];
        // ボタンを押す
        $response = $this->post('/login', $formData);
        // バリデーションを期待
        $response->assertSessionHasErrors('email');
        $this->assertEquals('メールアドレスを入力してください', session('errors')->first('email'));
    }

    public function test_user_password_validation()
    {
        // ログインページを開く
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // パスワードを入力せずに他の必須項目を入力する
        $formData = [
            'email' => 'sirakaba@sakamaki-forest.com',
            'password' => '',
        ];
        // ボタンを押す
        $response = $this->post('/login', $formData);
        // バリデーションを期待
        $response->assertSessionHasErrors('password');
        $this->assertEquals('パスワードを入力してください', session('errors')->first('password'));
    }

        public function test_incorrect_email_validation()
    {
        // 前準備、ユーザーデータを登録
        $formData = [
            'name' => 'hannoki',
            'email' => 'hannoki@sakamaki-forest.com',
            'password' => 'hannokihannoki',
            'password_confirmation' => 'hannokihannoki',
        ];
        $response = $this->post('/register', $formData);
        // ログアウト
        $response = $this->post('/logout');
        // ログインページを開く
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // 登録されていないメールアドレスを入力し他の必須項目を入力する
        $loginData = [
            'email' => 'dakekaba@sakamaki-forest.com',
            'password' => 'hannokihannoki',
        ];
        // ボタンを押す
        $response = $this->post('/login', $loginData);
        // バリデーションを期待
        $response->assertSessionHasErrors('email');
        $this->assertEquals('ログイン情報が登録されていません', session('errors')->first('email'));
    }

     public function test_incorrect_password_validation()
    {
        // 前準備、ユーザーデータを登録
        $formData = [
            'name' => 'yurinoki',
            'email' => 'yurinoki@sakamaki-forest.com',
            'password' => 'yurinokiyurinoki',
            'password_confirmation' => 'yurinokiyurinoki',
        ];
        $response = $this->post('/register', $formData);
        // ログアウト
        $response = $this->post('/logout');
        // ログインページを開く
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // 登録されていないパスワードを入力し他の必須項目を入力する
        $loginData = [
            'email' => 'yurinoki@sakamaki-forest.com',
            'password' => 'yurinokihannoki',
        ];
        // ボタンを押す
        $response = $this->post('/login', $loginData);
        // バリデーションを期待
        $response->assertSessionHasErrors('password');
        $this->assertEquals('ログイン情報が登録されていません', session('errors')->first('password'));
    }

    public function test_user_can_login()
    {
        // 前準備、ユーザーデータを登録
        $formData = [
            'name' => 'sirakaba',
            'email' => 'sirakaba@sakamaki-forest.com',
            'password' => 'sirakabasirakaba',
            'password_confirmation' => 'sirakabasirakaba',
        ];
        $response = $this->post('/register', $formData);
        // ログアウト
        $response = $this->post('/logout');
        // ログインページを開く
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // 全ての必要項目を入力
        $loginData= [
            'email' => 'sirakaba@sakamaki-forest.com',
            'password' => 'sirakabasirakaba',
        ];
        // ログインボタンを押す
        $response = $this->post('/login',$loginData);
        // 認証通過を期待
        $this->assertAuthenticated();
        // indexページへの移行('/')を期待
        $response->assertRedirect('/');
    }
}
