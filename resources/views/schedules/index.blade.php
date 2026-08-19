@extends('layouts.app')

@section('title', 'Schedule — RE:FORM')

@section('description', 'Manage your daily schedules.')

@section('content')

    {{-- ========================================
        HEADER
    ========================================= --}}

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Schedule
            </h1>

            <p class="page-subtitle">
                Atur dan kelola jadwal aktivitas lu.
            </p>

        </div>


        <a
            href="{{ route('schedules.create') }}"
            class="page-action"
        >
            + Tambah Jadwal
        </a>

    </div>


    {{-- ========================================
        SUCCESS MESSAGE
    ========================================= --}}

    @if (session('success'))

        <div class="alert-success">

            {{ session('success') }}

        </div>

    @endif


    {{-- ========================================
        SCHEDULE LIST
    ========================================= --}}

    <div class="schedule-list">

        @forelse ($schedules as $schedule)

            <article class="schedule-card">

                {{-- Time --}}

                <div class="schedule-time">

                    <span class="schedule-start">

                        {{ \Carbon\Carbon::parse(
                            $schedule->start_time
                        )->format('H:i') }}

                    </span>

                    <span class="schedule-separator">
                        —
                    </span>

                    <span class="schedule-end">

                        {{ \Carbon\Carbon::parse(
                            $schedule->end_time
                        )->format('H:i') }}

                    </span>

                </div>


                {{-- Main Content --}}

                <div class="schedule-content">

                    <div class="schedule-top">

                        <h2 class="schedule-title">

                            {{ $schedule->title }}

                        </h2>


                        {{-- Priority --}}

                        <span
                            class="schedule-priority priority-{{ $schedule->priority }}"
                        >

                            {{ ucfirst($schedule->priority) }}

                        </span>

                    </div>


                    {{-- Description --}}

                    @if ($schedule->description)

                        <p class="schedule-description">

                            {{ $schedule->description }}

                        </p>

                    @endif


                    {{-- Meta --}}

                    <div class="schedule-meta">

                        <span>

                            📅

                            {{ \Carbon\Carbon::parse(
                                $schedule->date
                            )->format('d M Y') }}

                        </span>


                        @if ($schedule->location)

                            <span>

                                📍

                                {{ $schedule->location }}

                            </span>

                        @endif


                        @if ($schedule->category)

                            <span>

                                <span
                                    class="category-dot"
                                    style="
                                        background:
                                        {{ $schedule->category->color }};
                                    "
                                ></span>

                                {{ $schedule->category->name }}

                            </span>

                        @endif

                    </div>

                </div>


                {{-- Status --}}

                <div class="schedule-status">

                    <span
                        class="status-badge status-{{ $schedule->status }}"
                    >

                        @switch($schedule->status)

                            @case('upcoming')
                                Akan datang
                                @break

                            @case('ongoing')
                                Berlangsung
                                @break

                            @case('completed')
                                Selesai
                                @break

                            @case('skipped')
                                Dilewati
                                @break

                            @case('cancelled')
                                Dibatalkan
                                @break

                            @default
                                {{ ucfirst($schedule->status) }}

                        @endswitch

                    </span>

                </div>


                {{-- Actions --}}

                <div class="schedule-actions">

                    <a
                        href="{{ route(
                            'schedules.show',
                            $schedule
                        ) }}"
                        class="schedule-action"
                        title="Lihat"
                    >
                        Lihat
                    </a>


                    <a
                        href="{{ route(
                            'schedules.edit',
                            $schedule
                        ) }}"
                        class="schedule-action"
                        title="Edit"
                    >
                        Edit
                    </a>


                    <form
                        method="POST"
                        action="{{ route(
                            'schedules.destroy',
                            $schedule
                        ) }}"
                        onsubmit="
                            return confirm(
                                'Yakin ingin menghapus jadwal ini?'
                            );
                        "
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="schedule-action schedule-delete"
                        >
                            Hapus
                        </button>

                    </form>

                </div>

            </article>

        @empty

            <div class="empty-state">

                <div class="empty-icon">
                    ◷
                </div>

                <h2>
                    Belum ada jadwal
                </h2>

                <p>
                    Mulai atur aktivitas lu dengan membuat
                    jadwal pertama.
                </p>

                <a
                    href="{{ route('schedules.create') }}"
                    class="page-action"
                >
                    + Tambah Jadwal
                </a>

            </div>

        @endforelse

    </div>


    {{-- ========================================
        PAGINATION
    ========================================= --}}

    @if ($schedules->hasPages())

        <div class="pagination">

            {{ $schedules->links() }}

        </div>

    @endif

@endsection