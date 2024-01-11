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
        $this->assertEmpty(Task::find(3));
        Task::factory()->create();
        $this->assertNotEmpty(Task::find(3));
    }

    public function test_relation_comment_table(): void
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

    public function test_relation_reference_table(): void
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
