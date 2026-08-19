<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'location',
        'priority',
        'status',
        'is_recurring',
        'recurrence_rule',
        'reminder_minutes',
    ];

    protected $casts = [
        'date' => 'date',
        'is_recurring' => 'boolean',
    ];

    /**
     * Schedule belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Schedule belongs to a category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}