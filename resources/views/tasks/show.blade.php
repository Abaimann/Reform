@extends('layouts.app')

@section('title', $task->title . ' — RE:FORM')

@section('description', 'Detail task ' . $task->title)

@section('content')

    {{-- ========================================
        HEADER
    ========================================= --}}

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Detail Task
            </h1>

            <p class="page-subtitle">
                Informasi lengkap mengenai task ini.
            </p>

        </div>

        <a
            href="{{ route('tasks.index') }}"
            class="schedule-back"
        >
            ← Kembali
        </a>

    </div>


    {{-- ========================================
        TASK DETAIL CARD
    ========================================= --}}

    <article class="task-detail-card">

        {{-- Header --}}

        <div class="task-detail-header">

            <div>

                <div class="task-detail-title-row">

                    <h2 class="task-detail-title">
                        {{ $task->title }}
                    </h2>

                    <span
                        class="
                            task-priority
                            task-priority-{{ $task->priority }}
                        "
                    >
                        {{ ucfirst($task->priority) }}
                    </span>

                </div>

                <span
                    class="
                        task-status
                        task-status-{{ $task->status }}
                    "
                >

                    @switch($task->status)

                        @case('pending')
                            Menunggu
                            @break

                        @case('in_progress')
                            Berlangsung
                            @break

                        @case('completed')
                            Selesai
                            @break

                        @case('cancelled')
                            Dibatalkan
                            @break

                        @default
                            {{ ucfirst($task->status) }}

                    @endswitch

                </span>

            </div>

        </div>


        {{-- ========================================
            DESCRIPTION
        ========================================= --}}

        @if ($task->description)

            <div class="task-detail-section">

                <h3>
                    Deskripsi
                </h3>

                <p class="task-detail-description">
                    {{ $task->description }}
                </p>

            </div>

        @endif


        {{-- ========================================
            PROGRESS
        ========================================= --}}

        <div class="task-detail-section">

            <div class="task-progress-header">

                <span>
                    Progress
                </span>

                <strong>
                    {{ $task->progress }}%
                </strong>

            </div>

            <div class="task-progress task-progress-large">

                <div
                    class="task-progress-bar"
                    style="width: {{ $task->progress }}%;"
                ></div>

            </div>

        </div>


        {{-- ========================================
            META
        ========================================= --}}

        <div class="task-detail-meta">

            @if ($task->due_date)

                <div class="task-detail-meta-item">

                    <span class="task-detail-meta-label">
                        Deadline
                    </span>

                    <strong>

                        {{ \Carbon\Carbon::parse(
                            $task->due_date
                        )->format('d M Y') }}

                    </strong>

                </div>

            @endif


            @if ($task->category)

                <div class="task-detail-meta-item">

                    <span class="task-detail-meta-label">
                        Kategori
                    </span>

                    <strong>

                        <span
                            class="category-dot"
                            style="
                                background:
                                {{ $task->category->color }};
                            "
                        ></span>

                        {{ $task->category->name }}

                    </strong>

                </div>

            @endif


            <div class="task-detail-meta-item">

                <span class="task-detail-meta-label">
                    Dibuat
                </span>

                <strong>

                    {{ $task->created_at->format('d M Y H:i') }}

                </strong>

            </div>

        </div>


        {{-- ========================================
            PARENT TASK
        ========================================= --}}

        @if ($task->parent)

            <div class="task-detail-section">

                <h3>
                    Parent Task
                </h3>

                <a
                    href="{{ route(
                        'tasks.show',
                        $task->parent
                    ) }}"
                    class="parent-task-link"
                >

                    {{ $task->parent->title }}

                </a>

            </div>

        @endif


        {{-- ========================================
            SUBTASKS
        ========================================= --}}

        <div class="task-detail-section">

            <div class="task-detail-section-header">

                <h3>
                    Subtask
                </h3>

                <span>
                    {{ $task->subtasks->count() }}
                </span>

            </div>


            @if ($task->subtasks->count())

                <div class="task-detail-subtasks">

                    @foreach ($task->subtasks as $subtask)

                        <a
                            href="{{ route(
                                'tasks.show',
                                $subtask
                            ) }}"
                            class="task-detail-subtask"
                        >

                            <div>

                                <span
                                    class="
                                        task-subtask-status
                                        task-status-{{
                                            $subtask->status
                                        }}
                                    "
                                ></span>

                                <span>
                                    {{ $subtask->title }}
                                </span>

                            </div>

                            <strong>
                                {{ $subtask->progress }}%
                            </strong>

                        </a>

                    @endforeach

                </div>

            @else

                <p class="task-no-subtask">
                    Belum ada subtask.
                </p>

            @endif

        </div>


        {{-- ========================================
            ACTIONS
        ========================================= --}}

        <div class="task-detail-actions">

            <a
                href="{{ route(
                    'tasks.edit',
                    $task
                ) }}"
                class="form-button form-button-secondary"
            >
                Edit Task
            </a>


            <form
                method="POST"
                action="{{ route(
                    'tasks.destroy',
                    $task
                ) }}"
                onsubmit="
                    return confirm(
                        'Yakin ingin menghapus task ini?'
                    );
                "
            >

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="
                        form-button
                        form-button-danger
                    "
                >
                    Hapus Task
                </button>

            </form>

        </div>

    </article>

@endsection