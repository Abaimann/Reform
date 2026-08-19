@extends('layouts.app')

@section('title', 'Tasks — RE:FORM')

@section('description', 'Manage your tasks and subtasks.')

@section('content')

    {{-- ========================================
        HEADER
    ========================================= --}}

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Tasks
            </h1>

            <p class="page-subtitle">
                Kelola pekerjaan dan target aktivitas lu.
            </p>

        </div>

        <a
            href="{{ route('tasks.create') }}"
            class="page-action"
        >
            + Tambah Task
        </a>

    </div>


    {{-- ========================================
        PESAN BERHASIL
    ========================================= --}}

    @if (session('success'))

        <div class="alert-success">

            {{ session('success') }}

        </div>

    @endif


    {{-- ========================================
        DAFTAR TASK
    ========================================= --}}

    <div class="task-list">

        @forelse ($tasks as $task)

            <article class="task-card">

                {{-- ========================================
                    TASK HEADER
                ========================================= --}}

                <div class="task-card-header">

                    <div class="task-title-wrapper">

                        <h2 class="task-title">
                            {{ $task->title }}
                        </h2>

                        {{-- Priority --}}

                        <span
                            class="
                                task-priority
                                task-priority-{{ $task->priority }}
                            "
                        >
                            {{ ucfirst($task->priority) }}
                        </span>

                    </div>


                    {{-- Status --}}

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


                {{-- ========================================
                    DESKRIPSI
                ========================================= --}}

                @if ($task->description)

                    <p class="task-description">

                        {{ $task->description }}

                    </p>

                @endif


                {{-- ========================================
                    PROGRESS
                ========================================= --}}

                <div class="task-progress-wrapper">

                    <div class="task-progress-header">

                        <span>
                            Progress
                        </span>

                        <strong>
                            {{ $task->progress }}%
                        </strong>

                    </div>

                    <div class="task-progress">

                        <div
                            class="task-progress-bar"
                            style="
                                width:
                                {{ $task->progress }}%;
                            "
                        ></div>

                    </div>

                </div>


                {{-- ========================================
                    META
                ========================================= --}}

                <div class="task-meta">

                    @if ($task->due_date)

                        <span>

                            📅

                            {{ \Carbon\Carbon::parse(
                                $task->due_date
                            )->format('d M Y') }}

                        </span>

                    @endif


                    @if ($task->category)

                        <span>

                            <span
                                class="category-dot"
                                style="
                                    background:
                                    {{ $task->category->color }};
                                "
                            ></span>

                            {{ $task->category->name }}

                        </span>

                    @endif


                    @if ($task->subtasks->count())

                        <span>

                            ☷

                            {{ $task->subtasks->count() }}
                            Subtask

                        </span>

                    @endif

                </div>


                {{-- ========================================
                    SUBTASK
                ========================================= --}}

                @if ($task->subtasks->count())

                    <div class="task-subtasks">

                        <div class="task-subtasks-title">

                            Subtask

                        </div>


                        @foreach ($task->subtasks as $subtask)

                            <div class="task-subtask">

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

                                <span>
                                    {{ $subtask->progress }}%
                                </span>

                            </div>

                        @endforeach

                    </div>

                @endif


                {{-- ========================================
                    AKSI
                ========================================= --}}

                <div class="task-actions">

                    <a
                        href="{{ route(
                            'tasks.show',
                            $task
                        ) }}"
                        class="task-action"
                    >
                        Lihat
                    </a>


                    <a
                        href="{{ route(
                            'tasks.edit',
                            $task
                        ) }}"
                        class="task-action"
                    >
                        Edit
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
                                task-action
                                task-action-delete
                            "
                        >
                            Hapus
                        </button>

                    </form>

                </div>

            </article>

        @empty

            {{-- ========================================
                EMPTY STATE
            ========================================= --}}

            <div class="empty-state">

                <div class="empty-icon">
                    ✓
                </div>

                <h2>
                    Belum ada task
                </h2>

                <p>
                    Mulai kelola pekerjaan lu dengan membuat
                    task pertama.
                </p>

                <a
                    href="{{ route('tasks.create') }}"
                    class="page-action"
                >
                    + Tambah Task
                </a>

            </div>

        @endforelse

    </div>


    {{-- ========================================
        PAGINATION
    ========================================= --}}

    @if ($tasks->hasPages())

        <div class="pagination">

            {{ $tasks->links() }}

        </div>

    @endif

@endsection