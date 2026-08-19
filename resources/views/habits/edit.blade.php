@extends('layouts.app')

@section('title', 'Edit Habit — RE:FORM')

@section('description', 'Edit habit RE:FORM.')

@section('content')

    {{-- ========================================
        HEADER
    ========================================= --}}

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Edit Habit
            </h1>

            <p class="page-subtitle">
                Perbarui kebiasaan dan target lu.
            </p>

        </div>

        <a
            href="{{ route('habits.show', $habit) }}"
            class="schedule-back"
        >
            ← Kembali
        </a>

    </div>


    {{-- ========================================
        ERROR
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


    <form
        method="POST"
        action="{{ route('habits.update', $habit) }}"
        class="habit-form"
    >

        @csrf

        @method('PUT')


        {{-- ========================================
            INFORMASI HABIT
        ========================================= --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Informasi Habit
                </h2>

                <p>
                    Perbarui informasi kebiasaan lu.
                </p>

            </div>


            <div class="form-grid">


                {{-- Nama --}}

                <div class="form-group form-group-full">

                    <label for="name">
                        Nama Habit
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old(
                            'name',
                            $habit->name
                        ) }}"
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
                    >{{ old(
                        'description',
                        $habit->description
                    ) }}</textarea>

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
                                    old(
                                        'category_id',
                                        $habit->category_id
                                    ) == $category->id
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
                                    $habit->frequency
                                ) === 'daily'
                            )
                        >
                            Setiap hari
                        </option>

                        <option
                            value="weekly"
                            @selected(
                                old(
                                    'frequency',
                                    $habit->frequency
                                ) === 'weekly'
                            )
                        >
                            Setiap minggu
                        </option>

                        <option
                            value="monthly"
                            @selected(
                                old(
                                    'frequency',
                                    $habit->frequency
                                ) === 'monthly'
                            )
                        >
                            Setiap bulan
                        </option>

                    </select>

                </div>

            </div>

        </div>


        {{-- ========================================
            TARGET
        ========================================= --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Target Habit
                </h2>

                <p>
                    Tentukan target kebiasaan lu.
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
                        value="{{ old(
                            'target',
                            $habit->target
                        ) }}"
                        min="1"
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
                        value="{{ old(
                            'unit',
                            $habit->unit
                        ) }}"
                        maxlength="50"
                        required
                    >

                </div>


                {{-- Reminder --}}

                <div class="form-group">

                    <label for="reminder_time">
                        Jam Pengingat
                    </label>

                    <input
                        type="time"
                        id="reminder_time"
                        name="reminder_time"
                        value="{{ old(
                            'reminder_time',
                            $habit->reminder_time
                                ? \Carbon\Carbon::parse(
                                    $habit->reminder_time
                                )->format('H:i')
                                : ''
                        ) }}"
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
                    Status
                </h2>

                <p>
                    Atur apakah habit sedang aktif.
                </p>

            </div>


            <label class="form-checkbox">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(
                        old(
                            'is_active',
                            $habit->is_active
                        )
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
                href="{{ route('habits.show', $habit) }}"
                class="form-button form-button-secondary"
            >
                Batal
            </a>

            <button
                type="submit"
                class="form-button form-button-primary"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

@endsection