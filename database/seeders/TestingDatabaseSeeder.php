<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Models\Reference;
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
        
        Comment::factory()->create([
            'task_id' => 1,
            'comment' => 'test_comment'
        ]);

        Reference::factory()->create([
            'task_id' => 1,
            'source' => 'test_referemce'
        ]);
        
    }
}
