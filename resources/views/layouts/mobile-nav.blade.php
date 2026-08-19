<nav class="mobile-nav">

    <a
        href="{{ route('dashboard') }}"
        class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
    >

        <span class="mobile-nav-icon">
            ⌂
        </span>

        <span>
            Today
        </span>

    </a>


    <a
        href="#"
        class="mobile-nav-item"
    >

        <span class="mobile-nav-icon">
            ◷
        </span>

        <span>
            Schedule
        </span>

    </a>


    <a
        href="#"
        class="mobile-nav-item"
    >

        <span class="mobile-nav-icon">
            ✓
        </span>

        <span>
            Tasks
        </span>

    </a>


    <a
        href="#"
        class="mobile-nav-item"
    >

        <span class="mobile-nav-icon">
            ↻
        </span>

        <span>
            Habits
        </span>

    </a>


    <a
        href="#"
        class="mobile-nav-item"
    >

        <span class="mobile-nav-icon">
            ☰
        </span>

        <span>
            More
        </span>

    </a>

</nav>