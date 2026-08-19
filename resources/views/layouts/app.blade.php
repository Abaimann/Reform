<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'RE:FORM')
    </title>

    <meta
        name="description"
        content="@yield(
            'description',
            'Personal Productivity & Habit Management System'
        )"
    >

    @vite([
        'resources/css/app.css',
        'resources/css/layouts.css',
        'resources/css/dashboard.css',
        'resources/css/schedule.css',
        'resources/css/tasks.css',
        'resources/js/app.js'
        
    ])

    @stack('styles')

</head>


<body>

    <div class="app-layout">

        {{-- Sidebar desktop --}}

        @include('layouts.sidebar')


        {{-- Konten utama --}}

        <main class="app-main">

            <div class="app-content">

                @yield('content')

            </div>

        </main>


        {{-- Navigasi mobile --}}

        @include('layouts.mobile-nav')

    </div>


    @stack('scripts')

</body>

</html>