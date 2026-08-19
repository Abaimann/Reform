<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habit extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'frequency',
        'target',
        'unit',
        'reminder_time',
        'is_active',
    ];


    protected $casts = [
        'reminder_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];


    /**
     * User pemilik habit.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Kategori habit.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * Riwayat penyelesaian habit.
     */
    public function completions(): HasMany
    {
        return $this->hasMany(
            HabitCompletion::class
        );
    }
}