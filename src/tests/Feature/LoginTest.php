<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
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
        ->create();
        $users = User::all();
        foreach ($users as $user){
        $loginData=[
            'name'=> $user['name'],
            'email' => $user['email'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        // 前準備、ユーザーデータを登録
        $response = $this->post('/register', $loginData);
        // ログアウト
        $response = $this->post('/logout');
        }
    }

    public function test_user_email_validation()
    {
        // ログインページを開く
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // メールアドレスを入力せずに他の必須項目を入力する
        $loginData = [
            'email' => '',
            'password' => 'password',
        ];
        // ボタンを押す
        $response = $this->post('/login', $loginData);
        // バリデーションを期待
        $response->assertSessionHasErrors('email');
        $this->assertEquals('メールアドレスを入力してください', session('errors')->first('email'));
    }

    public function test_user_password_validation()
    {
        $users = User::all();
        // ログインページを開く
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        foreach ($users as $user){
            // パスワードを入力せずに他の必須項目を入力する
            $loginData = [
                'email' => $user['email'],
                'password' => '',
            ];
            // ボタンを押す
            $response = $this->post('/login', $loginData);
            // バリデーションを期待
            $response->assertSessionHasErrors('password');
            $this->assertEquals('パスワードを入力してください', session('errors')->first('password'));
        }
    }

    public function test_incorrect_email_validation()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        // 登録されていないメールアドレスを入力し他の必須項目を入力する
        $login_user = User::find(rand(1,10));
        $loginData = [
            'email' => 'not'.$login_user['email'],
            'password' => 'password',
        ];
        // ボタンを押す
        $response = $this->post('/login', $loginData);
        // バリデーションを期待
        $this->assertGuest();
        $response->assertSessionHasErrors('email');
        $this->assertEquals('ログイン情報が登録されていません', session('errors')->first('email'));
    }

    public function test_incorrect_password_validation()
    {
        $users = User::all();
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        foreach($users as $user){
            // 登録されていないパスワードを入力し他の必須項目を入力する
            $loginData = [
                'email' => $user['email'],
                'password' => 'notpassword',
            ];
            // ボタンを押す
            $response = $this->post('/login', $loginData);
            // バリデーションを期待
            $response->assertSessionHasErrors('password');
            $this->assertEquals('ログイン情報が登録されていません', session('errors')->first('password'));
        }
    }

    public function test_user_can_login()
    {
        $users = User::all();
        // ログインページを開く
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        foreach($users as $user){
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
        }
    }
}
