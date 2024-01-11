<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Database\Seeders\TestingDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase; //テストごとにmigrate:freshする

    protected string $seeder = TestingDatabaseSeeder::class;
}
