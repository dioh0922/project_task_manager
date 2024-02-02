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
        Schema::create('relations', function (Blueprint $table) {

            // それぞれのタスクIDは外部キー制約にしておく(登録済のみ)
            $table->unsignedBigInteger('base_task_id');
            $table->foreign('base_task_id')->references('id')->on('tasks');
            $table->unsignedBigInteger('child_task_id');
            $table->foreign('child_task_id')->references('id')->on('tasks');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relations');
    }
};
