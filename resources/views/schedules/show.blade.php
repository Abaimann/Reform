@extends('layouts.app')

@section('title', 'Detail Schedule — RE:FORM')

@section('description', 'Detail jadwal aktivitas RE:FORM.')

@section('content')

    {{-- ========================================
        HEADER
    ========================================= --}}

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Detail Jadwal
            </h1>

            <p class="page-subtitle">
                Informasi lengkap mengenai jadwal aktivitas lu.
            </p>

        </div>

        <div class="page-header-actions">

            {{-- Tombol kembali --}}

            <a
                href="{{ route('schedules.index') }}"
                class="page-action page-action-secondary"
            >
                ← Kembali
            </a>

            {{-- Tombol edit --}}

            <a
                href="{{ route('schedules.edit', $schedule) }}"
                class="page-action"
            >
                Edit Jadwal
            </a>

        </div>

    </div>


    {{-- ========================================
        DETAIL CARD
    ========================================= --}}

    <article class="schedule-detail-card">

        {{-- Judul --}}

        <div class="schedule-detail-header">

            <div>

                <div class="schedule-detail-title-row">

                    <h2 class="schedule-detail-title">
                        {{ $schedule->title }}
                    </h2>

                    {{-- Priority --}}

                    <span
                        class="schedule-priority priority-{{ $schedule->priority }}"
                    >
                        {{ ucfirst($schedule->priority) }}
                    </span>

                </div>

                {{-- Status --}}

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

        </div>


        {{-- ========================================
            WAKTU
        ========================================= --}}

        <div class="schedule-detail-section">

            <h3>
                Waktu
            </h3>

            <div class="schedule-detail-grid">

                <div class="schedule-detail-item">

                    <span class="schedule-detail-label">
                        Tanggal
                    </span>

                    <span class="schedule-detail-value">

                        📅

                        {{ \Carbon\Carbon::parse(
                            $schedule->date
                        )->format('d M Y') }}

                    </span>

                </div>


                <div class="schedule-detail-item">

                    <span class="schedule-detail-label">
                        Waktu
                    </span>

                    <span class="schedule-detail-value">

                        🕐

                        {{ \Carbon\Carbon::parse(
                            $schedule->start_time
                        )->format('H:i') }}

                        —

                        {{ \Carbon\Carbon::parse(
                            $schedule->end_time
                        )->format('H:i') }}

                    </span>

                </div>

            </div>

        </div>


        {{-- ========================================
            INFORMASI AKTIVITAS
        ========================================= --}}

        <div class="schedule-detail-section">

            <h3>
                Informasi Aktivitas
            </h3>

            <div class="schedule-detail-grid">

                {{-- Lokasi --}}

                <div class="schedule-detail-item">

                    <span class="schedule-detail-label">
                        Lokasi
                    </span>

                    <span class="schedule-detail-value">

                        @if ($schedule->location)

                            📍 {{ $schedule->location }}

                        @else

                            Tidak ada lokasi

                        @endif

                    </span>

                </div>


                {{-- Kategori --}}

                <div class="schedule-detail-item">

                    <span class="schedule-detail-label">
                        Kategori
                    </span>

                    <span class="schedule-detail-value">

                        @if ($schedule->category)

                            <span
                                class="category-dot"
                                style="
                                    background:
                                    {{ $schedule->category->color }};
                                "
                            ></span>

                            {{ $schedule->category->name }}

                        @else

                            Tanpa kategori

                        @endif

                    </span>

                </div>

            </div>

        </div>


        {{-- ========================================
            DESKRIPSI
        ========================================= --}}

        @if ($schedule->description)

            <div class="schedule-detail-section">

                <h3>
                    Deskripsi
                </h3>

                <p class="schedule-detail-description">
                    {{ $schedule->description }}
                </p>

            </div>

        @endif


        {{-- ========================================
            PENGINGAT
        ========================================= --}}

        <div class="schedule-detail-section">

            <h3>
                Pengingat
            </h3>

            <div class="schedule-detail-grid">

                <div class="schedule-detail-item">

                    <span class="schedule-detail-label">
                        Pengingat
                    </span>

                    <span class="schedule-detail-value">

                        @if ($schedule->reminder_minutes !== null)

                            {{ $schedule->reminder_minutes }}
                            menit sebelum jadwal

                        @else

                            Tidak ada pengingat

                        @endif

                    </span>

                </div>


                <div class="schedule-detail-item">

                    <span class="schedule-detail-label">
                        Jadwal Berulang
                    </span>

                    <span class="schedule-detail-value">

                        @if ($schedule->is_recurring)

                            Ya

                        @else

                            Tidak

                        @endif

                    </span>

                </div>

            </div>

        </div>


        {{-- ========================================
            ATURAN PENGULANGAN
        ========================================= --}}

        @if ($schedule->is_recurring && $schedule->recurrence_rule)

            <div class="schedule-detail-section">

                <h3>
                    Aturan Pengulangan
                </h3>

                <p class="schedule-detail-description">
                    {{ $schedule->recurrence_rule }}
                </p>

            </div>

        @endif


        {{-- ========================================
            AKSI
        ========================================= --}}

        <div class="schedule-detail-actions">

            <a
                href="{{ route('schedules.edit', $schedule) }}"
                class="page-action"
            >
                Edit Jadwal
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
                    class="page-action page-action-danger"
                >
                    Hapus Jadwal
                </button>

            </form>

        </div>

    </article>

@endsection