<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'start_date',
        'deadline',
        'progress',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class);
    }
}