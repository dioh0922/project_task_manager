<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TaskTest extends TestCase
{

    public function test_task_index(): void
    {
        $response = $this->get('/task');

        $response->assertStatus(200);
        $response->assertSee('タスク一覧');
    }

    public function test_show_task_create(): void
    {
        $user = User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 1
        ]);
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/task/create');

        $response->assertStatus(200);
        $response->assertSee('新規作成');
    }

    public function test_show_task_create_unauth(): void
    {

        $response = $this->get('/task/create');

        $response->assertStatus(302)->assertRedirect('/login');

    }

    public function test_create_task_object(): void
    {
        $data = [
            'summary' => 'test_create_summary',
            'detail' => 'test_create_detail',
            'reference' => 'test_create_reference'
        ];
        $response = $this->postJson('/task', $data);
        $response->assertStatus(302);

        $user = User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 1
        ]);
        $id = Task::max('id'); //最新の採番からとる
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('task/'.$id);

        $response->assertStatus(200);
        $response->assertSee('test_create_summary');
        $response->assertSee('test_create_detail');
        $response->assertSee('test_create_reference');
    }

    public function test_create_task_object_empty_summary(): void
    {
        // 必須はsummaryのみ
        $data = [
            'summary' => '',
            'detail' => 'test_create_detail',
            'reference' => 'test_create_reference'
        ];
        $response = $this->postJson('/task', $data);
        $response->assertStatus(422);
        $response->assertSee('The summary field is required.');
    }

    public function test_show_task_object(): void
    {

        $user = User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 1
        ]);
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/task/1');

        $response->assertStatus(200);
        $response->assertSee('test_task');
    }

    public function test_show_task_object_unauth(): void
    {

        $response = $this->get('/task/1');

        $response->assertStatus(302)->assertRedirect('/login');

    }

    public function test_show_task_object_not_found(): void
    {

        $user = User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 1
        ]);
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/task/99');

        $response->assertStatus(302)->assertRedirect('/task');
        $response = $this->get('/task');
        $response->assertSee('タスクが見つかりません:id=99');
    }

    public function test_show_task_object_closed(): void
    {
        $this->deleteJson('/task/2');
        $response = $this->get('/task/2');
        $response->assertStatus(200);
        $response->assertSee('test_task');

        //完了後は編集ボタンが消える
        $response->assertDontSee('編集');
    }

    public function test_update_task_object(): void
    {
        $data = [
            'detail' => 'test_detail_edit',
            'comment' => 'test_comment',
            'reference' => 'test_reference'
        ];

        $response = $this->putJson('/task/1', $data);
        $response->assertStatus(302);

        $user = User::factory()->create([
            'userID' => 'test_create',
            'pass' => 'test_pass',
            'accept' => 1
        ]);
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/task/1');


        $response->assertSee('test_detail_edit');
        $response->assertSee('test_comment');
        $response->assertSee('test_reference');

    }

    public function test_delete_task_object(): void
    {
        $pre_response = $this->get('/task');
        $pre_response->assertStatus(200);
        $pre_response->assertDontSee('完了済');

        $response = $this->deleteJson('/task/2');
        $response->assertStatus(302);
        $response = $this->get('/task');
        $response->assertSee('完了済');
    }

    public function test_show_edit_task(): void
    {
        // task/{task}/edit is do nothing
        $response = $this->get('/task/1/edit');
        $response->assertStatus(302);
    }

}
