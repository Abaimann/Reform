@extends('layouts.app')

@section('title', 'Habits — RE:FORM')

@section('description', 'Manage your daily habits.')

@section('content')

    {{-- ========================================
        HEADER
    ========================================= --}}

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Habits
            </h1>

            <p class="page-subtitle">
                Bangun kebiasaan kecil yang membentuk versi diri lu.
            </p>

        </div>

        <a
            href="{{ route('habits.create') }}"
            class="page-action"
        >
            + Tambah Habit
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
        DAFTAR HABIT
    ========================================= --}}

    <div class="habit-list">

        @forelse ($habits as $habit)

            <article class="habit-card">

                {{-- ========================================
                    HEADER HABIT
                ========================================= --}}

                <div class="habit-card-header">

                    <div class="habit-title-wrapper">

                        <span class="habit-icon">
                            ↻
                        </span>

                        <div>

                            <h2 class="habit-title">
                                {{ $habit->name }}
                            </h2>

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


                    {{-- Status --}}

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


                {{-- ========================================
                    DESKRIPSI
                ========================================= --}}

                @if ($habit->description)

                    <p class="habit-description">

                        {{ $habit->description }}

                    </p>

                @endif


                {{-- ========================================
                    INFORMASI HABIT
                ========================================= --}}

                <div class="habit-meta">

                    <div class="habit-meta-item">

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


                    <div class="habit-meta-item">

                        <span class="habit-meta-label">
                            Target
                        </span>

                        <strong>

                            {{ $habit->target }}

                            {{ $habit->unit }}

                        </strong>

                    </div>


                    @if ($habit->reminder_time)

                        <div class="habit-meta-item">

                            <span class="habit-meta-label">
                                Pengingat
                            </span>

                            <strong>

                                🔔

                                {{ \Carbon\Carbon::parse(
                                    $habit->reminder_time
                                )->format('H:i') }}

                            </strong>

                        </div>

                    @endif


                    <div class="habit-meta-item">

                        <span class="habit-meta-label">
                            Selesai
                        </span>

                        <strong>

                            {{ $habit->completions_count }}

                            kali

                        </strong>

                    </div>

                </div>


                {{-- ========================================
                    AKSI
                ========================================= --}}

                <div class="habit-actions">

                    <a
                        href="{{ route(
                            'habits.show',
                            $habit
                        ) }}"
                        class="habit-action"
                    >
                        Lihat
                    </a>


                    <a
                        href="{{ route(
                            'habits.edit',
                            $habit
                        ) }}"
                        class="habit-action"
                    >
                        Edit
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
                                habit-action
                                habit-action-delete
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
                    ↻
                </div>

                <h2>
                    Belum ada habit
                </h2>

                <p>
                    Mulai bangun kebiasaan baru dengan membuat
                    habit pertama lu.
                </p>

                <a
                    href="{{ route('habits.create') }}"
                    class="page-action"
                >
                    + Tambah Habit
                </a>

            </div>

        @endforelse

    </div>


    {{-- ========================================
        PAGINATION
    ========================================= --}}

    @if ($habits->hasPages())

        <div class="pagination">

            {{ $habits->links() }}

        </div>

    @endif

@endsection