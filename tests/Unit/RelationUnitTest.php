<?php

namespace Tests\Unit;

use App\Models\Relation;

use Tests\TestCase;

class RelationUnitTest extends TestCase
{
    public function test_load_table(): void
    {
        $relation = Relation::where('base_task_id', 1)->where('child_task_id', 1)->first();
        $this->assertEquals(1, $relation->base_task_id);
        $this->assertEquals(1, $relation->child_task_id);
        $this->assertEquals(0, $relation->task_depth);
    }

    public function test_factory_able(): void
    {
        $this->assertEmpty(Relation::where('base_task_id', 1)->where('child_task_id', 8)->first());
        Relation::factory()->create([
            'base_task_id' => 1,
            'child_task_id' => 8,
            'task_depth' => 1
        ]);
        $this->assertNotEmpty(Relation::where('base_task_id', 1)->where('child_task_id', 8)->first());
    }

    public function test_faild_child_not_exists_task_id(): void
    {
        $this->assertEmpty(Relation::where('base_task_id', 1)->where('child_task_id', 99)->first());
        $this->assertThrows(
            fn() => Relation::factory()->create([
                'base_task_id' => 1,
                'child_task_id' => 99,
                'task_depth' => 1]),
                \Illuminate\Database\QueryException::class
        );
    }

    public function test_faild_parent_not_exists_task_id(): void
    {
        $this->assertEmpty(Relation::where('base_task_id', 99)->where('child_task_id', 1)->first());
        $this->assertThrows(
            fn() => Relation::factory()->create([
                'base_task_id' => 99,
                'child_task_id' => 1,
                'task_depth' => 1]),
                \Illuminate\Database\QueryException::class
        );
    }

}
