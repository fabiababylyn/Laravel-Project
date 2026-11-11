
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">

        {{-- Website Logo / Name --}}
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <span>📚</span> Library Resource Management
        </a>

        {{-- Mobile Toggle --}}
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#libraryNavbar"
            aria-controls="libraryNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="libraryNavbar">

            {{-- Left Navigation --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- Public Navigation --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('catalog') ? 'active' : '' }}"
                       href="{{ route('catalog') }}">
                        Book Catalog
                    </a>
                </li>

                @auth

                    {{-- Admin and Librarian Navigation --}}
                    @if(in_array(auth()->user()->role, ['admin', 'librarian']))

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                               href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}"
                               href="{{ route('books.index') }}">
                                Manage Books
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('borrowers.*') ? 'active' : '' }}"
                               href="{{ route('borrowers.index') }}">
                                Borrowers
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('loans.*') ? 'active' : '' }}"
                               href="{{ route('loans.index') }}">
                                Borrowing Records
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports') ? 'active' : '' }}"
                               href="{{ route('reports') }}">
                                Reports
                            </a>
                        </li>

                    @endif

                    {{-- Student Navigation --}}
                    @if(auth()->user()->role === 'student')

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                               href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('my-loans') ? 'active' : '' }}"
                               href="{{ route('my-loans') }}">
                                My Loans
                            </a>
                        </li>

                    @endif

                @endauth

            </ul>

            {{-- Right Navigation --}}
            <ul class="navbar-nav ms-auto align-items-lg-center">

                @guest

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-lg-2"
                           href="{{ route('register') }}">
                            Register
                        </a>
                    </li>

                @else

                    <li class="nav-item">
                        <span class="nav-link text-white">
                            {{ auth()->user()->name }}
                            <span class="badge bg-primary">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </span>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}"
                              method="POST"
                              class="d-inline">
                            @csrf

                            <button type="submit"
                                    class="btn btn-outline-light btn-sm ms-lg-2">
                                Logout
                            </button>
                        </form>
                    </li>

                @endguest

            </ul>

        </div>
    </div>
</nav>
