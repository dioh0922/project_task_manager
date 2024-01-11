<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\Comment;
use Tests\TestCase;

class CommentUnitTest extends TestCase
{
    public function test_load_table(): void
    {
        // 指定したテーブルに接続できているかテストする
        $comment = Comment::find(1);
        $this->assertEquals('test_comment', $comment->comment);
        $this->assertEquals(1, $comment->task_id);
    }
    
    public function test_factoryable(): void
    {
        $this->assertEmpty(Comment::find(2));
        Comment::factory()->create([
            'task_id' => 1,
            'comment' => fake()->realText($maxNbChars = 35)
        ]);
        $this->assertNotEmpty(Comment::find(2));
    }

    public function test_relation_comment_table(): void
    {
        $tasks = Task::find(1);
        $this->assertNotEmpty($tasks);

        $comment = Comment::factory()->create([
            'task_id' => $tasks->id,
            'comment' => fake()->realText($maxNbChars = 35)
        ]);
        // 追加したレコードと紐付いているか確認
        $this->assertNotEmpty($comment->task);
    }
}
