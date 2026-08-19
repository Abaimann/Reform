@extends('layouts.app')

@section('title', 'Tambah Task — RE:FORM')

@section('description', 'Tambah task baru ke RE:FORM.')

@section('content')

    {{-- ========================================
        HEADER
    ========================================= --}}

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Tambah Task
            </h1>

            <p class="page-subtitle">
                Buat pekerjaan baru dan atur progresnya.
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
        action="{{ route('tasks.store') }}"
        class="task-form"
    >

        @csrf


        {{-- ========================================
            INFORMASI TASK
        ========================================= --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Informasi Task
                </h2>

                <p>
                    Tentukan pekerjaan yang ingin lu selesaikan.
                </p>

            </div>


            <div class="form-grid">


                {{-- Judul --}}

                <div class="form-group form-group-full">

                    <label for="title">
                        Judul Task
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Contoh: Menyelesaikan database RE:FORM"
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
                        placeholder="Jelaskan pekerjaan yang perlu dilakukan..."
                    >{{ old('description') }}</textarea>

                </div>


                {{-- Deadline --}}

                <div class="form-group">

                    <label for="due_date">
                        Deadline
                    </label>

                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                        value="{{ old('due_date') }}"
                    >

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

            </div>

        </div>


        {{-- ========================================
            PARENT TASK
        ========================================= --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Struktur Task
                </h2>

                <p>
                    Pilih parent task jika pekerjaan ini merupakan subtask.
                </p>

            </div>


            <div class="form-group">

                <label for="parent_id">
                    Parent Task
                </label>

                <select
                    id="parent_id"
                    name="parent_id"
                >

                    <option value="">
                        Task utama
                    </option>

                    @foreach ($parentTasks as $parentTask)

                        <option
                            value="{{ $parentTask->id }}"
                            @selected(
                                old('parent_id')
                                == $parentTask->id
                            )
                        >
                            {{ $parentTask->title }}
                        </option>

                    @endforeach

                </select>

                <small class="form-help">
                    Pilih task utama jika task ini ingin dijadikan subtask.
                </small>

            </div>

        </div>


        {{-- ========================================
            PRIORITAS & STATUS
        ========================================= --}}

        <div class="form-section">

            <div class="form-section-header">

                <h2>
                    Prioritas & Status
                </h2>

                <p>
                    Atur tingkat kepentingan dan kondisi task.
                </p>

            </div>


            <div class="form-grid">


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
                            @selected(
                                old('priority', 'medium')
                                === 'low'
                            )
                        >
                            Low
                        </option>

                        <option
                            value="medium"
                            @selected(
                                old('priority', 'medium')
                                === 'medium'
                            )
                        >
                            Medium
                        </option>

                        <option
                            value="high"
                            @selected(
                                old('priority')
                                === 'high'
                            )
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
                            value="pending"
                            @selected(
                                old('status', 'pending')
                                === 'pending'
                            )
                        >
                            Menunggu
                        </option>

                        <option
                            value="in_progress"
                            @selected(
                                old('status')
                                === 'in_progress'
                            )
                        >
                            Berlangsung
                        </option>

                        <option
                            value="completed"
                            @selected(
                                old('status')
                                === 'completed'
                            )
                        >
                            Selesai
                        </option>

                        <option
                            value="cancelled"
                            @selected(
                                old('status')
                                === 'cancelled'
                            )
                        >
                            Dibatalkan
                        </option>

                    </select>

                </div>


                {{-- Progress --}}

                <div class="form-group">

                    <label for="progress">
                        Progress
                        <span>*</span>
                    </label>

                    <input
                        type="number"
                        id="progress"
                        name="progress"
                        value="{{ old('progress', 0) }}"
                        min="0"
                        max="100"
                        step="1"
                        required
                    >

                    <small class="form-help">
                        Masukkan nilai antara 0 sampai 100.
                    </small>

                </div>

            </div>

        </div>


        {{-- ========================================
            TOMBOL
        ========================================= --}}

        <div class="form-actions">

            <a
                href="{{ route('tasks.index') }}"
                class="form-button form-button-secondary"
            >
                Batal
            </a>

            <button
                type="submit"
                class="form-button form-button-primary"
            >
                Simpan Task
            </button>

        </div>

    </form>

@endsection