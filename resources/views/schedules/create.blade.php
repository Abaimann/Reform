@extends('layouts.app')

@section('title', 'Tambah Schedule — RE:FORM')

@section('description', 'Tambah jadwal baru ke RE:FORM.')

@section('content')

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Tambah Jadwal
            </h1>

            <p class="page-subtitle">
                Buat jadwal baru untuk mengatur aktivitas lu.
            </p>

        </div>

        <a
            href="{{ route('schedules.index') }}"
            class="schedule-back"
        >
            ← Kembali
        </a>

    </div>


    @if ($errors->any())

        <div class="form-errors">

            <strong>
                Ada data yang perlu diperbaiki:
            </strong>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('schedules.store') }}"
        class="schedule-form"
    >

        @csrf


        {{-- Informasi utama --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Informasi Jadwal
                </h2>

                <p>
                    Tentukan aktivitas dan waktu pelaksanaannya.
                </p>

            </div>


            <div class="form-grid">


                {{-- Judul --}}

                <div class="form-group form-group-full">

                    <label for="title">
                        Judul Jadwal
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Contoh: Coding Laravel"
                        maxlength="255"
                        required
                    >

                </div>


                {{-- Deskripsi --}}

                <div class="form-group form-group-full">

                    <label for="description">
                        Deskripsi
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Jelaskan aktivitas yang akan dilakukan..."
                    >{{ old('description') }}</textarea>

                </div>


                {{-- Tanggal --}}

                <div class="form-group">

                    <label for="date">
                        Tanggal
                        <span>*</span>
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ old('date') }}"
                        required
                    >

                </div>


                {{-- Lokasi --}}

                <div class="form-group">

                    <label for="location">
                        Lokasi
                    </label>

                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="Contoh: Home"
                        maxlength="255"
                    >

                </div>


                {{-- Jam mulai --}}

                <div class="form-group">

                    <label for="start_time">
                        Jam Mulai
                        <span>*</span>
                    </label>

                    <input
                        type="time"
                        id="start_time"
                        name="start_time"
                        value="{{ old('start_time') }}"
                        required
                    >

                </div>


                {{-- Jam selesai --}}

                <div class="form-group">

                    <label for="end_time">
                        Jam Selesai
                        <span>*</span>
                    </label>

                    <input
                        type="time"
                        id="end_time"
                        name="end_time"
                        value="{{ old('end_time') }}"
                        required
                    >

                </div>

            </div>

        </div>


        {{-- Kategori dan prioritas --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Kategori & Prioritas
                </h2>

                <p>
                    Atur kategori dan tingkat kepentingan jadwal.
                </p>

            </div>


            <div class="form-grid">


                {{-- Category --}}

                <div class="form-group">

                    <label for="category_id">
                        Kategori
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                    >

                        <option value="">
                            Tanpa kategori
                        </option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old('category_id')
                                    == $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Priority --}}

                <div class="form-group">

                    <label for="priority">
                        Prioritas
                        <span>*</span>
                    </label>

                    <select
                        id="priority"
                        name="priority"
                        required
                    >

                        <option
                            value="low"
                            @selected(old('priority', 'medium') === 'low')
                        >
                            Low
                        </option>

                        <option
                            value="medium"
                            @selected(old('priority', 'medium') === 'medium')
                        >
                            Medium
                        </option>

                        <option
                            value="high"
                            @selected(old('priority') === 'high')
                        >
                            High
                        </option>

                    </select>

                </div>


                {{-- Status --}}

                <div class="form-group">

                    <label for="status">
                        Status
                        <span>*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option
                            value="upcoming"
                            @selected(
                                old('status', 'upcoming')
                                === 'upcoming'
                            )
                        >
                            Akan datang
                        </option>

                        <option
                            value="ongoing"
                            @selected(old('status') === 'ongoing')
                        >
                            Berlangsung
                        </option>

                        <option
                            value="completed"
                            @selected(old('status') === 'completed')
                        >
                            Selesai
                        </option>

                        <option
                            value="skipped"
                            @selected(old('status') === 'skipped')
                        >
                            Dilewati
                        </option>

                        <option
                            value="cancelled"
                            @selected(old('status') === 'cancelled')
                        >
                            Dibatalkan
                        </option>

                    </select>

                </div>


                {{-- Reminder --}}

                <div class="form-group">

                    <label for="reminder_minutes">
                        Reminder
                    </label>

                    <select
                        id="reminder_minutes"
                        name="reminder_minutes"
                    >

                        <option value="">
                            Tanpa reminder
                        </option>

                        <option
                            value="5"
                            @selected(old('reminder_minutes') == 5)
                        >
                            5 menit sebelumnya
                        </option>

                        <option
                            value="10"
                            @selected(old('reminder_minutes') == 10)
                        >
                            10 menit sebelumnya
                        </option>

                        <option
                            value="15"
                            @selected(old('reminder_minutes') == 15)
                        >
                            15 menit sebelumnya
                        </option>

                        <option
                            value="30"
                            @selected(old('reminder_minutes') == 30)
                        >
                            30 menit sebelumnya
                        </option>

                        <option
                            value="60"
                            @selected(old('reminder_minutes') == 60)
                        >
                            1 jam sebelumnya
                        </option>

                    </select>

                </div>

            </div>

        </div>


        {{-- Pengulangan --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Pengulangan
                </h2>

                <p>
                    Atur apakah jadwal ini berulang.
                </p>

            </div>


            <div class="recurring-box">

                <label class="checkbox-label">

                    <input
                        type="checkbox"
                        name="is_recurring"
                        value="1"
                        id="is_recurring"
                        @checked(old('is_recurring'))
                    >

                    <span>
                        Jadwal ini berulang
                    </span>

                </label>


                <div
                    class="form-group recurring-rule"
                    id="recurring-rule"
                >

                    <label for="recurrence_rule">
                        Aturan Pengulangan
                    </label>

                    <select
                        id="recurrence_rule"
                        name="recurrence_rule"
                    >

                        <option value="">
                            Pilih pengulangan
                        </option>

                        <option
                            value="daily"
                            @selected(
                                old('recurrence_rule') === 'daily'
                            )
                        >
                            Setiap hari
                        </option>

                        <option
                            value="weekly"
                            @selected(
                                old('recurrence_rule') === 'weekly'
                            )
                        >
                            Setiap minggu
                        </option>

                        <option
                            value="monthly"
                            @selected(
                                old('recurrence_rule') === 'monthly'
                            )
                        >
                            Setiap bulan
                        </option>

                    </select>

                </div>

            </div>

        </div>


        {{-- Tombol --}}

        <div class="form-actions">

            <a
                href="{{ route('schedules.index') }}"
                class="form-button form-button-secondary"
            >
                Batal
            </a>

            <button
                type="submit"
                class="form-button form-button-primary"
            >
                Simpan Jadwal
            </button>

        </div>

    </form>

@endsection


@push('scripts')

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const checkbox =
                    document.getElementById('is_recurring');

                const recurringRule =
                    document.getElementById('recurring-rule');

                function toggleRecurringRule() {

                    if (checkbox.checked) {

                        recurringRule.style.display = 'block';

                    } else {

                        recurringRule.style.display = 'none';

                    }

                }

                toggleRecurringRule();

                checkbox.addEventListener(
                    'change',
                    toggleRecurringRule
                );

            }
        );

    </script>

@endpush