<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Milestone extends Model
{
    protected $fillable = [
        'goal_id',
        'title',
        'description',
        'due_date',
        'is_completed',
        'completed_at',
        'sort_order',
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }
}