@extends('layouts.app')

@section('title', 'Tambah Habit — RE:FORM')

@section('description', 'Tambah habit baru ke RE:FORM.')

@section('content')

    {{-- ========================================
        HEADER
    ========================================= --}}

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Tambah Habit
            </h1>

            <p class="page-subtitle">
                Bangun kebiasaan baru dan konsisten setiap hari.
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
        PESAN ERROR
    ========================================= --}}

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


    {{-- ========================================
        FORM HABIT
    ========================================= --}}

    <form
        method="POST"
        action="{{ route('habits.store') }}"
        class="habit-form"
    >

        @csrf


        {{-- ========================================
            INFORMASI HABIT
        ========================================= --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Informasi Habit
                </h2>

                <p>
                    Tentukan kebiasaan yang ingin lu bangun.
                </p>

            </div>


            <div class="form-grid">


                {{-- Nama Habit --}}

                <div class="form-group form-group-full">

                    <label for="name">
                        Nama Habit
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Belajar coding"
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
                        placeholder="Jelaskan kebiasaan yang ingin lu bangun..."
                    >{{ old('description') }}</textarea>

                </div>


                {{-- Kategori --}}

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


                {{-- Frekuensi --}}

                <div class="form-group">

                    <label for="frequency">
                        Frekuensi
                        <span>*</span>
                    </label>

                    <select
                        id="frequency"
                        name="frequency"
                        required
                    >

                        <option
                            value="daily"
                            @selected(
                                old(
                                    'frequency',
                                    'daily'
                                ) === 'daily'
                            )
                        >
                            Setiap hari
                        </option>

                        <option
                            value="weekly"
                            @selected(
                                old('frequency')
                                === 'weekly'
                            )
                        >
                            Setiap minggu
                        </option>

                        <option
                            value="monthly"
                            @selected(
                                old('frequency')
                                === 'monthly'
                            )
                        >
                            Setiap bulan
                        </option>

                    </select>

                </div>

            </div>

        </div>


        {{-- ========================================
            TARGET HABIT
        ========================================= --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Target Habit
                </h2>

                <p>
                    Tentukan target yang ingin dicapai.
                </p>

            </div>


            <div class="form-grid">


                {{-- Target --}}

                <div class="form-group">

                    <label for="target">
                        Target
                        <span>*</span>
                    </label>

                    <input
                        type="number"
                        id="target"
                        name="target"
                        value="{{ old('target', 1) }}"
                        min="1"
                        step="1"
                        required
                    >

                </div>


                {{-- Unit --}}

                <div class="form-group">

                    <label for="unit">
                        Unit
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="unit"
                        name="unit"
                        value="{{ old('unit', 'session') }}"
                        placeholder="Contoh: menit, halaman, session"
                        maxlength="50"
                        required
                    >

                </div>


                {{-- Jam Pengingat --}}

                <div class="form-group">

                    <label for="reminder_time">
                        Jam Pengingat
                    </label>

                    <input
                        type="time"
                        id="reminder_time"
                        name="reminder_time"
                        value="{{ old('reminder_time') }}"
                    >

                    <small class="form-help">
                        Kosongkan jika tidak membutuhkan pengingat.
                    </small>

                </div>

            </div>

        </div>


        {{-- ========================================
            STATUS
        ========================================= --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Status Habit
                </h2>

                <p>
                    Tentukan apakah habit langsung aktif.
                </p>

            </div>


            <label class="form-checkbox">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(
                        old('is_active', true)
                    )
                >

                <span>
                    Aktifkan habit
                </span>

            </label>

        </div>


        {{-- ========================================
            TOMBOL
        ========================================= --}}

        <div class="form-actions">

            <a
                href="{{ route('habits.index') }}"
                class="form-button form-button-secondary"
            >
                Batal
            </a>

            <button
                type="submit"
                class="form-button form-button-primary"
            >
                Simpan Habit
            </button>

        </div>

    </form>

@endsection