<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\Reference;
use Tests\TestCase;

class ReferenceUnitTest extends TestCase
{
    public function test_load_table(): void
    {
        // 指定したテーブルに接続できているかテストする
        $reference = Reference::find(1);
        $this->assertEquals('test_referemce', $reference->source);
        $this->assertEquals(1, $reference->task_id);
    }

    public function test_factoryable(): void
    {
        $this->assertEmpty(Reference::find(2));
        Reference::factory()->create([
            'task_id' => 1,
            'source' => fake()->realText($maxNbChars = 35)
        ]);
        $this->assertNotEmpty(Reference::find(2));
    }

    public function test_relation_reference_table(): void
    {
        $tasks = Task::find(1);
        $this->assertNotEmpty($tasks);

        $reference = Reference::factory()->create([
            'task_id' => $tasks->id,
            'source' => fake()->realText($maxNbChars = 35)
        ]);
        // 追加したレコードと紐付いているか確認
        $this->assertNotEmpty($reference->task);
    }
}
