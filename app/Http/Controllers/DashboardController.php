<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Habit;
use App\Models\Journal;
use App\Models\Mood;
use App\Models\Schedule;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $today = Carbon::today();

        // Today's Schedule
        $schedules = Schedule::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get();

        // Today's Tasks
        $tasks = Task::where('user_id', $user->id)
            ->whereDate('due_date', $today)
            ->orderByRaw("
                CASE priority
                    WHEN 'high' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'low' THEN 3
                    ELSE 4
                END
            ")
            ->get();

        // Active Habits
        $habits = Habit::where('user_id', $user->id)
            ->where('is_active', true)
            ->with([
                'completions' => function ($query) use ($today) {
                    $query->whereDate('completed_at', $today);
                }
            ])
            ->get();

        // Active Goals
        $goals = Goal::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->orderBy('deadline')
            ->get();

        // Today's Mood
        $mood = Mood::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        // Today's Journal
        $journal = Journal::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        return view('dashboard.index', compact(
            'schedules',
            'tasks',
            'habits',
            'goals',
            'mood',
            'journal'
        ));
    }
}