<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\Comment;
use App\Models\Reference;
use Tests\TestCase;

class TaskUnitTest extends TestCase
{
    public function test_load_table(): void
    {
        $tasks = Task::find(1);
        $this->assertEquals('test_task', $tasks->summary);
    }

    public function test_factory_able(): void
    {
        // TODO: idの変数化 20240302
        $this->assertEmpty(Task::find(9));
        Task::factory()->create();
        $this->assertNotEmpty(Task::find(9));
    }

    /** Task->idに一意で紐付くもののテスト */
    public function test_optional_comment_table(): void
    {
        $this->assertNotEmpty(Task::find(1));
        $tasks = Task::find(1);
        // テストデータでは1レコード紐付いている
        $this->assertEquals(1, count($tasks->comments));
        Comment::factory()->create([
            'task_id' => $tasks->id,
            'comment' => fake()->realText($maxNbChars = 35)
        ]);
        // 追加したレコードと紐付いているか確認
        $this->assertEquals(2, count($tasks->refresh()->comments));
    }

    public function test_optional_reference_table(): void
    {
        $this->assertNotEmpty(Task::find(1));
        $tasks = Task::find(1);
        // テストデータでは1レコード紐付いている
        $this->assertEquals(1, count($tasks->references));
        Reference::factory()->create([
            'task_id' => $tasks->id,
            'source' => fake()->realText($maxNbChars = 35)
        ]);
        // 追加したレコードと紐付いているか確認
        $this->assertEquals(2, count($tasks->refresh()->references));
    }
}
