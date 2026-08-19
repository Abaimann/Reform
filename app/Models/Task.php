<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'parent_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'progress',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    /**
     * Task belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Task belongs to a category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Parent task.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    /**
     * Subtasks.
     */
    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }
}