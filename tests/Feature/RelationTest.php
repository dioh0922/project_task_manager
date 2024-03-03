<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RelationTest extends TestCase
{
    public function test_show_relation(): void
    {
        $user = User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 1
        ]);
        $test_id = 3; //SeederのタスクID固定
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('relation/'.$test_id);

        $response->assertStatus(200);
        $response->assertSee('関連追加');
        $response->assertSee('子タスク');
        $response->assertSee('孫タスク');
        $response->assertSee('最上位タスク');
    }

    public function test_show_relation_unauth(): void
    {
        $test_id = 3; //SeederのタスクID固定
        $response = $this->get('relation/'.$test_id);
        $response->assertStatus(302)->assertRedirect('/login');
    }

    public function test_add_relation_parent():void
    {
        $user = User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 1
        ]);

        $data = [
            'target' => 1, //親タスクモード
            'id' => 1,
            'child' => 1,
            'parent' => 2
        ];
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->postJson('/relation', $data);
        $response->assertStatus(302);

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('relation/1');

        $response->assertStatus(200);
        $response->assertSee('関連上位タスク');
        $response->assertSee('test_task_delete');

    }

    public function test_add_relation_child():void
    {
        $user = User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 1
        ]);

        $data = [
            'target' => 0, //親タスクモード
            'id' => 1,
            'child' => 1,
            'parent' => 2
        ];
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->postJson('/relation', $data);
        $response->assertStatus(302);

        $user = User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 1
        ]);
        $id = 3;
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('relation/1');

        $response->assertStatus(200);
        $response->assertSee('関連子タスク');
        $response->assertSee('test_task_delete');

    }

    public function test_delete_relation_child():void
    {
        $user = User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 1
        ]);
        $response = $this->actingAs($user)
                            ->withSession(['banned' => false])
                            ->get('relation/8');
        $response->assertStatus(200);
        $response->assertSee('関連子タスク');
        $response->assertSee('親タスク');

        $data = [
            'child' => 3,
            'parent' => 8
        ];
        $response = $this->actingAs($user)
                            ->withSession(['banned' => false])
                            ->putJson('/relation/8', $data);
        $response->assertStatus(302);

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('relation/8');

        $response->assertStatus(200);
        $response->assertDontSee('関連子タスク');
    }

    public function test_add_relation_unauth(): void
    {
        $data = [
            'target' => 0, //親タスクモード
            'id' => 1,
            'child' => 1,
            'parent' => 2
        ];
        $response = $this->postJson('/relation', $data);
        $response->assertStatus(302)->assertRedirect('/login');
    }

    public function test_delete_relation_unauth(): void
    {
        $data = [
            'child' => 3,
            'parent' => 8
        ];
        $response = $this->putJson('/relation/8', $data);

        $response->assertStatus(302)->assertRedirect('/login');
    }


}
