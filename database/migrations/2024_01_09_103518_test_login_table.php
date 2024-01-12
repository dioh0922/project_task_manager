<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //本番では別管理しているため、テスト環境のみマイグレーション実行
        if(env('APP_ENV') === 'testing')
        {            
            Schema::create('login', function (Blueprint $table) {
                $table->string('userID')->nullable(false);
                $table->string('pass')->nullable(false);
                $table->integer('accept')->nullable(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
