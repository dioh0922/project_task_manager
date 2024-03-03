<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Models\Reference;
use App\Models\Relation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        User::factory()->create([
            'userID' => 'test_user',
            'pass' => 'test_pass',
            'accept' => 1
        ]);

        User::factory()->create([
            'userID' => 'test_delete',
            'pass' => 'test_pass',
            'accept' => 0
        ]);

        Task::factory()->create([
            'summary' => 'test_task',
            'detail' => 'test_detail',
        ]);

        Task::factory()->create([
            'summary' => 'test_task_delete',
            'detail' => 'test_detail_delete',
        ]);

        // 関連性用タスク
        //id3
        Task::factory()->create([
            'summary' => '親タスク',
            'detail' => '親タスク',
        ]);
        //id4
        Task::factory()->create([
            'summary' => '子タスク',
            'detail' => '子タスク',
        ]);
        //id5
        Task::factory()->create([
            'summary' => '孫タスク',
            'detail' => '孫タスク',
        ]);

        //id6
        Task::factory()->create([
            'summary' => '子タスク2',
            'detail' => '子タスク2',
        ]);
        //id7
        Task::factory()->create([
            'summary' => '孫タスク2',
            'detail' => '孫タスク2',
        ]);
        //id8
        Task::factory()->create([
            'summary' => '最上位タスク',
            'detail' => '最上位タスク',
        ]);

        Comment::factory()->create([
            'task_id' => 1,
            'comment' => 'test_comment'
        ]);

        Reference::factory()->create([
            'task_id' => 1,
            'source' => 'test_referemce'
        ]);

        for($i = 1; $i <= 8; $i++){
            Relation::factory()->create([
                'base_task_id' => $i,
                'child_task_id' => $i,
                'task_depth' => 0
            ]);
        }

        Relation::factory()->create([
            'base_task_id' => 8,
            'child_task_id' => 3,
            'task_depth' => 1
        ]);

        Relation::factory()->create([
            'base_task_id' => 8,
            'child_task_id' => 4,
            'task_depth' => 2
        ]);

        Relation::factory()->create([
            'base_task_id' => 8,
            'child_task_id' => 5,
            'task_depth' => 3
        ]);

        Relation::factory()->create([
            'base_task_id' => 3,
            'child_task_id' => 4,
            'task_depth' => 1
        ]);

        Relation::factory()->create([
            'base_task_id' => 4,
            'child_task_id' => 5,
            'task_depth' => 2
        ]);

        Relation::factory()->create([
            'base_task_id' => 6,
            'child_task_id' => 7,
            'task_depth' => 1
        ]);

    }
}
