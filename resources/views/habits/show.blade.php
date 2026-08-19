@extends('layouts.app')

@section('title', $habit->name . ' — RE:FORM')

@section('description', 'Detail habit ' . $habit->name)

@section('content')

    {{-- ========================================
        HEADER
    ========================================= --}}

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Detail Habit
            </h1>

            <p class="page-subtitle">
                Lihat informasi dan riwayat habit lu.
            </p>

        </div>

        <a
            href="{{ route('habits.index') }}"
            class="schedule-back"
        >
            ← Kembali
        </a>

    </div>


    {{-- ========================================
        SUCCESS
    ========================================= --}}

    @if (session('success'))

        <div class="alert-success">

            {{ session('success') }}

        </div>

    @endif


    {{-- ========================================
        DETAIL CARD
    ========================================= --}}

    <article class="habit-detail-card">


        {{-- Header --}}

        <div class="habit-detail-header">

            <div class="habit-title-wrapper">

                <span class="habit-icon">
                    ↻
                </span>

                <div>

                    <div class="habit-detail-title-row">

                        <h2 class="habit-detail-title">
                            {{ $habit->name }}
                        </h2>

                        <span
                            class="
                                habit-status
                                {{
                                    $habit->is_active
                                        ? 'habit-status-active'
                                        : 'habit-status-inactive'
                                }}
                            "
                        >
                            {{ $habit->is_active
                                ? 'Aktif'
                                : 'Nonaktif'
                            }}
                        </span>

                    </div>


                    @if ($habit->category)

                        <span class="habit-category">

                            <span
                                class="category-dot"
                                style="
                                    background:
                                    {{ $habit->category->color }};
                                "
                            ></span>

                            {{ $habit->category->name }}

                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- ========================================
            DESKRIPSI
        ========================================= --}}

        @if ($habit->description)

            <div class="habit-detail-section">

                <h3>
                    Deskripsi
                </h3>

                <p class="habit-detail-description">
                    {{ $habit->description }}
                </p>

            </div>

        @endif


        {{-- ========================================
            INFORMASI
        ========================================= --}}

        <div class="habit-detail-section">

            <div class="habit-detail-grid">


                <div class="habit-detail-meta-item">

                    <span class="habit-meta-label">
                        Frekuensi
                    </span>

                    <strong>

                        @switch($habit->frequency)

                            @case('daily')
                                Setiap hari
                                @break

                            @case('weekly')
                                Setiap minggu
                                @break

                            @case('monthly')
                                Setiap bulan
                                @break

                            @default
                                {{ ucfirst($habit->frequency) }}

                        @endswitch

                    </strong>

                </div>


                <div class="habit-detail-meta-item">

                    <span class="habit-meta-label">
                        Target
                    </span>

                    <strong>

                        {{ $habit->target }}
                        {{ $habit->unit }}

                    </strong>

                </div>


                <div class="habit-detail-meta-item">

                    <span class="habit-meta-label">
                        Pengingat
                    </span>

                    <strong>

                        @if ($habit->reminder_time)

                            🔔

                            {{ \Carbon\Carbon::parse(
                                $habit->reminder_time
                            )->format('H:i') }}

                        @else

                            Tidak ada

                        @endif

                    </strong>

                </div>


                <div class="habit-detail-meta-item">

                    <span class="habit-meta-label">
                        Total Selesai
                    </span>

                    <strong>

                        {{ $habit->completions->count() }}
                        kali

                    </strong>

                </div>

            </div>

        </div>


        {{-- ========================================
            SELESAIKAN HARI INI
        ========================================= --}}

        @php

            $completedToday = $habit->completions
                ->contains(function ($completion) {

                    return $completion->completed_at
                        ->isToday();

                });

        @endphp


        <div class="habit-complete-section">

            @if ($completedToday)

                <div class="habit-completed-message">

                    ✓ Habit hari ini sudah selesai

                </div>

            @elseif ($habit->is_active)

                <form
                    method="POST"
                    action="{{ route(
                        'habits.complete',
                        $habit
                    ) }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="habit-complete-button"
                    >
                        ✓ Tandai Selesai Hari Ini
                    </button>

                </form>

            @else

                <div class="habit-inactive-message">

                    Habit sedang nonaktif.

                </div>

            @endif

        </div>


        {{-- ========================================
            RIWAYAT
        ========================================= --}}

        <div class="habit-detail-section">

            <div class="habit-detail-section-header">

                <h3>
                    Riwayat Penyelesaian
                </h3>

                <span>
                    {{ $habit->completions->count() }}
                </span>

            </div>


            @if ($habit->completions->count())

                <div class="habit-completion-list">

                    @foreach (
                        $habit->completions
                            ->sortByDesc('completed_at')
                            as $completion
                    )

                        <div class="habit-completion-item">

                            <div>

                                <span class="habit-completion-icon">
                                    ✓
                                </span>

                                <div>

                                    <strong>

                                        {{ $completion->completed_at
                                            ->format('d M Y')
                                        }}

                                    </strong>

                                    @if ($completion->notes)

                                        <p>
                                            {{ $completion->notes }}
                                        </p>

                                    @endif

                                </div>

                            </div>


                            @if (!is_null($completion->value))

                                <span class="habit-completion-value">

                                    {{ $completion->value }}
                                    {{ $habit->unit }}

                                </span>

                            @endif

                        </div>

                    @endforeach

                </div>

            @else

                <p class="habit-no-completion">

                    Belum ada riwayat penyelesaian.

                </p>

            @endif

        </div>


        {{-- ========================================
            ACTION
        ========================================= --}}

        <div class="habit-detail-actions">

            <a
                href="{{ route(
                    'habits.edit',
                    $habit
                ) }}"
                class="form-button form-button-secondary"
            >
                Edit Habit
            </a>


            <form
                method="POST"
                action="{{ route(
                    'habits.destroy',
                    $habit
                ) }}"
                onsubmit="
                    return confirm(
                        'Yakin ingin menghapus habit ini?'
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
                    Hapus Habit
                </button>

            </form>

        </div>

    </article>

@endsection