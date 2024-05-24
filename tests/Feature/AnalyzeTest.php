<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnalyzeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_show_analyze(): void
    {
        $response = $this->get('/analyze');
        $response->assertStatus(200);
        $response->assertSee('タスク分析');
        //デフォルトではチェックを非活性なことは確認
        $response->assertDontSee('checked');
        $response->assertSee('disabled');

    }

    public function test_show_relation_target_checked(): void
    {

        $data = [
            'id' => 3,
            'close' => 1
        ];
        $response = $this->postJson('/analyze', $data);

        $response->assertStatus(200);
        $response->assertSee('タスク分析');
        $response->assertSee('checked');
    }

    public function test_show_relation_default_unchecked(): void
    {

        $data = [
            'id' => 3,
            'close' => 0
        ];
        $response = $this->postJson('/analyze', $data);

        $response->assertStatus(200);
        $response->assertSee('タスク分析');
        $response->assertDontSee('checked');
    }

    public function test_show_github(): void
    {

        $response = $this->get('/analyze/github');

        $response->assertStatus(200);
        $response->assertSee('Githubアカウント');
        $response->assertSee('x-axis');
    }


}
