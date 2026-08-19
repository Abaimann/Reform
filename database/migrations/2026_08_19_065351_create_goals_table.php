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
        Schema::create('goals', function (Blueprint $table) {
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

            $table->date('start_date')->nullable();

            $table->date('deadline')->nullable();

            $table->unsignedTinyInteger('progress')->default(0);

            $table->enum('status', [
                'not_started',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('not_started');

            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'deadline']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};