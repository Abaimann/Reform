<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'icon',
        'color',
    ];

    /**
     * Category belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Category has many schedules.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Category has many tasks.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Category has many habits.
     */
    public function habits(): HasMany
    {
        return $this->hasMany(Habit::class);
    }

    /**
     * Category has many goals.
     */
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }
}