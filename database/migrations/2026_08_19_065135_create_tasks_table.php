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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('tasks')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->date('due_date')->nullable();

            $table->enum('priority', [
                'low',
                'medium',
                'high'
            ])->default('medium');

            $table->enum('status', [
                'pending',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->unsignedTinyInteger('progress')->default(0);

            $table->timestamps();

            $table->index(['user_id', 'due_date']);
            $table->index(['category_id', 'due_date']);
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};