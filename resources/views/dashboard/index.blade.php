@extends('layouts.app')

@section('title', 'Today — RE:FORM')

@section(
    'description',
    'Your personal productivity dashboard.'
)

@section('content')

    {{-- ========================================
        HEADER
    ========================================= --}}

    <div class="dashboard-header">

        <div>

            <h1 class="dashboard-title">

                Good evening,
                {{ auth()->user()->name }}
                👋

            </h1>

            <p class="dashboard-subtitle">

                {{ now()->format('l, d F Y') }}

            </p>

        </div>

    </div>


    {{-- ========================================
        DASHBOARD GRID
    ========================================= --}}

    <div class="dashboard-grid">


        {{-- ====================================
            TODAY'S PROGRESS
        ===================================== --}}

        <div
            class="dashboard-card"
            style="grid-column: span 8;"
        >

            <h2>
                Today's Progress
            </h2>

            <p>
                Your productivity overview will appear here.
            </p>

        </div>


        {{-- ====================================
            STREAK
        ===================================== --}}

        <div
            class="dashboard-card"
            style="grid-column: span 4;"
        >

            <h2>
                🔥 Streak
            </h2>

            <p>
                0 Days
            </p>

        </div>


        {{-- ====================================
            TODAY'S SCHEDULE
        ===================================== --}}

        <div
            class="dashboard-card"
            style="grid-column: span 6;"
        >

            <h2>
                Today's Schedule
            </h2>


            @forelse ($schedules as $schedule)

                <div class="dashboard-list-item">

                    <strong>
                        {{ $schedule->start_time }}
                    </strong>

                    <span>
                        {{ $schedule->title }}
                    </span>

                </div>

            @empty

                <p>
                    No schedule yet.
                </p>

            @endforelse

        </div>


        {{-- ====================================
            TODAY'S TASKS
        ===================================== --}}

        <div
            class="dashboard-card"
            style="grid-column: span 6;"
        >

            <h2>
                Today's Tasks
            </h2>


            @forelse ($tasks as $task)

                <div class="dashboard-list-item">

                    <span>

                        @if ($task->status === 'completed')
                            ✓
                        @else
                            ○
                        @endif

                    </span>

                    <strong>
                        {{ $task->title }}
                    </strong>

                </div>

            @empty

                <p>
                    No tasks yet.
                </p>

            @endforelse

        </div>


        {{-- ====================================
            TODAY'S HABITS
        ===================================== --}}

        <div
            class="dashboard-card"
            style="grid-column: span 6;"
        >

            <h2>
                Today's Habits
            </h2>


            @forelse ($habits as $habit)

                <div class="dashboard-list-item">

                    <span>

                        @if ($habit->completions->isNotEmpty())
                            ✓
                        @else
                            ○
                        @endif

                    </span>

                    <strong>
                        {{ $habit->name }}
                    </strong>

                </div>

            @empty

                <p>
                    No active habits.
                </p>

            @endforelse

        </div>


        {{-- ====================================
            GOALS
        ===================================== --}}

        <div
            class="dashboard-card"
            style="grid-column: span 6;"
        >

            <h2>
                Active Goals
            </h2>


            @forelse ($goals as $goal)

                <div class="dashboard-goal">

                    <div class="dashboard-goal-header">

                        <strong>
                            {{ $goal->title }}
                        </strong>

                        <span>
                            {{ $goal->progress }}%
                        </span>

                    </div>


                    <div class="dashboard-progress">

                        <div
                            class="dashboard-progress-bar"
                            style="width: {{ $goal->progress }}%;"
                        ></div>

                    </div>

                </div>

            @empty

                <p>
                    No active goals.
                </p>

            @endforelse

        </div>


        {{-- ====================================
            MOOD
        ===================================== --}}

        <div
            class="dashboard-card"
            style="grid-column: span 4;"
        >

            <h2>
                Today's Mood
            </h2>


            @if ($mood)

                <div class="dashboard-mood">

                    @switch($mood->mood)

                        @case('excellent')
                            😄
                            @break

                        @case('good')
                            🙂
                            @break

                        @case('okay')
                            😐
                            @break

                        @case('bad')
                            😔
                            @break

                        @case('terrible')
                            😫
                            @break

                        @default
                            😐

                    @endswitch

                    <span>
                        {{ ucfirst($mood->mood) }}
                    </span>

                </div>

            @else

                <p>
                    No mood recorded today.
                </p>

            @endif

        </div>


        {{-- ====================================
            JOURNAL
        ===================================== --}}

        <div
            class="dashboard-card"
            style="grid-column: span 8;"
        >

            <h2>
                Today's Journal
            </h2>


            @if ($journal)

                <strong>
                    {{ $journal->title }}
                </strong>

                <p>
                    {{ $journal->content }}
                </p>

            @else

                <p>
                    No journal entry today.
                </p>

            @endif

        </div>


    </div>

@endsection