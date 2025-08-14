<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    public function test_user_logout_validation()
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
        // logoutボタンを押下
        $response = $this->post('/logout');
        //logoutを期待
        $this->assertGuest();
    }
}
