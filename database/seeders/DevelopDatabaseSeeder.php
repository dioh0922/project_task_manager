<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Comment;
use App\Models\Reference;


class DevelopDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 15; $i++){
            $delete = 0;
            if($i%2 == 0){
                $delete = 1;
            }
            Task::factory()->create([
                'summary' => fake()->realText($maxNbChars = 35),
                'detail' => fake()->realText($maxNbChars = 35),
                'is_delete' => $delete,
            ]);
        }

        for($i = 0; $i < 3; $i++){
            Comment::factory()->create([
                'task_id' => 1,
                'comment' => fake()->realText($maxNbChars = 35)
            ]);

            Reference::factory()->create([
                'task_id' => 1,
                'source' => 'http://'.fake()->realText($maxNbChars = 10)
            ]);
        }

        for($i = 0; $i < 5; $i++){
            Comment::factory()->create([
                'task_id' => 2,
                'comment' => fake()->realText($maxNbChars = 35)
            ]);

            Reference::factory()->create([
                'task_id' => 2,
                'source' => 'http://'.fake()->realText($maxNbChars = 10)
            ]);
        }
    }
}
