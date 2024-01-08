<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\DB;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{    
    /**
     * A basic feature test example.
     */
    public function test_login_index(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('ログイン');
    }

    public function test_logout(): void
    {
        $response = $this->get('/logout');
        $response->assertStatus(200);
        $response->assertSee('ログアウトしました');
    }

    public function test_login(): void
    {
        
        $data = [
            'userID' => 'test_user',
            'password' => 'test_pass',
        ];

        $response = $this->postJson('/login', $data);

        $response->assertStatus(302)
            ->assertRedirect('/task');
    }

    public function test_login_faild(): void
    {
        
        $data = [
            'userID' => 'test_user',
            'password' => 'test_faild',
        ];

        $response = $this->postJson('/login', $data);

        $response->assertStatus(302);

        $response = $this->get('login');

        $response->assertSee('ログイン情報が不正です');
    }
}
