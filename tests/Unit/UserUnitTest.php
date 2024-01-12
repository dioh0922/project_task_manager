<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserUnitTest extends TestCase
{
    public function test_load_table(): void
    {
        // Userクラスが指定したテーブルに接続できているかテストする
        $user = User::find('test_user');
        $this->assertEquals('test_user', $user->userID);
        $this->assertEquals(1, $user->accept);
    }

    public function test_factory_able(): void
    {
        $this->assertEmpty(User::find('test_create'));
        User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 0
        ]);
        $this->assertNotEmpty(User::find('test_create'));
    }

}
