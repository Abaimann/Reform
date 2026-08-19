@extends('layouts.app')


@section('title', 'Today — RE:FORM')


@section(
    'description',
    'Your personal productivity dashboard.'
)


@section('content')


    {{-- ========================================
        DASHBOARD HEADER
    ========================================= --}}

    <div class="dashboard-header">

        <div>

            <h1 class="dashboard-title">

                Good evening,
                {{ auth()->user()->name }}
                👋

            </h1>


            <p class="dashboard-subtitle">

                {{ now()->format('l, d F Y') }}

            </p>

        </div>

    </div>


    {{-- ========================================
        DASHBOARD GRID
    ========================================= --}}

    <div class="dashboard-grid">


        {{-- Progress --}}

        <div
            class="dashboard-card"
            style="grid-column: span 8;"
        >

            <h2>
                Today's Progress
            </h2>

            <p>
                Your productivity overview will appear here.
            </p>

        </div>


        {{-- Streak --}}

        <div
            class="dashboard-card"
            style="grid-column: span 4;"
        >

            <h2>
                🔥 Streak
            </h2>

            <p>
                0 Days
            </p>

        </div>


        {{-- Schedule --}}

        <div
            class="dashboard-card"
            style="grid-column: span 6;"
        >

            <h2>
                Today's Schedule
            </h2>

            <p>
                No schedule yet.
            </p>

        </div>


        {{-- Tasks --}}

        <div
            class="dashboard-card"
            style="grid-column: span 6;"
        >

            <h2>
                Today's Tasks
            </h2>

            <p>
                No tasks yet.
            </p>

        </div>


    </div>


@endsection