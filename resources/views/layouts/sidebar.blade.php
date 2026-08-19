<aside class="app-sidebar">

    <div class="sidebar-inner">

        {{-- ========================================
            LOGO
        ========================================= --}}

        <div class="sidebar-logo">

            <a
                href="{{ route('dashboard') }}"
                class="logo-link"
            >

                <span class="logo-mark">

                    <img
                        src="{{ asset('images/reform-logo.png') }}"
                        alt="RE:FORM Logo"
                    >

                </span>

                <span class="logo-text">
                    RE:FORM
                </span>

            </a>

        </div>


        {{-- ========================================
            NAVIGASI
        ========================================= --}}

        <nav class="sidebar-nav">


            {{-- ====================================
                WORKSPACE
            ===================================== --}}

            <div class="nav-section">

                <span class="nav-section-title">
                    Workspace
                </span>


                {{-- Today --}}

                <a
                    href="{{ route('dashboard') }}"
                    class="nav-item
                        {{ request()->routeIs('dashboard')
                            ? 'active'
                            : '' }}"
                >

                    <span class="nav-icon">
                        ⌂
                    </span>

                    <span>
                        Today
                    </span>

                </a>


                {{-- Schedule --}}

                <a
                    href="{{ route('schedules.index') }}"
                    class="nav-item
                        {{ request()->routeIs('schedules.*')
                            ? 'active'
                            : '' }}"
                >

                    <span class="nav-icon">
                        ◷
                    </span>

                    <span>
                        Schedule
                    </span>

                </a>


                {{-- Tasks --}}

                <a
                    href="{{ route('tasks.index') }}"
                    class="nav-item
                        {{ request()->routeIs('tasks.*')
                            ? 'active'
                            : '' }}"
                >

                    <span class="nav-icon">
                        ✓
                    </span>

                    <span>
                        Tasks
                    </span>

                </a>


                {{-- Habits --}}

                <a
                    href="{{ route('habits.index') }}"
                    class="nav-item
                        {{ request()->routeIs('habits.*')
                            ? 'active'
                            : '' }}"
                >

                    <span class="nav-icon">
                        ↻
                    </span>

                    <span>
                        Habits
                    </span>

                </a>


                {{-- Goals --}}

                <a
                    href="#"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        □
                    </span>

                    <span>
                        Goals
                    </span>

                </a>

            </div>


            {{-- ====================================
                PERSONAL
            ===================================== --}}

            <div class="nav-section">

                <span class="nav-section-title">
                    Personal
                </span>


                {{-- Calendar --}}

                <a
                    href="#"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ▦
                    </span>

                    <span>
                        Calendar
                    </span>

                </a>


                {{-- Journal --}}

                <a
                    href="#"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ✎
                    </span>

                    <span>
                        Journal
                    </span>

                </a>


                {{-- Mood --}}

                <a
                    href="#"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ☺
                    </span>

                    <span>
                        Mood
                    </span>

                </a>


                {{-- Statistics --}}

                <a
                    href="#"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ◔
                    </span>

                    <span>
                        Statistics
                    </span>

                </a>

            </div>

        </nav>


        {{-- ========================================
            BAGIAN BAWAH SIDEBAR
        ========================================= --}}

        <div class="sidebar-bottom">


            {{-- Settings --}}

            <a
                href="#"
                class="nav-item"
            >

                <span class="nav-icon">
                    ⚙
                </span>

                <span>
                    Settings
                </span>

            </a>


            {{-- Logout --}}

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="nav-item"
                    style="
                        width: 100%;
                        border: none;
                        background: transparent;
                        text-align: left;
                    "
                >

                    <span class="nav-icon">
                        ↪
                    </span>

                    <span>
                        Logout
                    </span>

                </button>

            </form>


            {{-- User --}}

            <div class="sidebar-user">

                <div class="user-avatar">

                    {{ strtoupper(
                        substr(
                            auth()->user()->name,
                            0,
                            1
                        )
                    ) }}

                </div>


                <div class="user-info">

                    <span class="user-name">

                        {{ auth()->user()->name }}

                    </span>


                    <span class="user-email">

                        {{ auth()->user()->email }}

                    </span>

                </div>

            </div>

        </div>

    </div>

</aside>