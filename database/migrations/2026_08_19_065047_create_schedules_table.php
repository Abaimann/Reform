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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();

            $table->string('location')->nullable();

            $table->enum('priority', [
                'low',
                'medium',
                'high'
            ])->default('medium');

            $table->enum('status', [
                'upcoming',
                'ongoing',
                'completed',
                'skipped',
                'cancelled'
            ])->default('upcoming');

            $table->boolean('is_recurring')->default(false);

            $table->string('recurrence_rule')->nullable();

            $table->unsignedInteger('reminder_minutes')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'date']);
            $table->index(['category_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};