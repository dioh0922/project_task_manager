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
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('detail')->nullable()->change();
            $table->string('reference')->nullable()->change();
            $table->timestamp('closed_at')->nullable()->change();
            $table->string('comment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('detail')->nullable(false)->change();
            $table->string('reference')->nullable(false)->change();
            $table->timestamp('closed_at')->nullable(false)->change();
            $table->string('comment')->nullable(false)->change();
        });
    }
};
