<header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="/">Pengelolaan Surat</a>

    {{-- <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false"
                aria-label="Toggle search">
                <svg class="bi">
                    <use xlink:href="#search" />
                </svg>
            </button>
        </li>
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <svg class="bi">
                    <use xlink:href="#list" />
                </svg>
            </button>
        </li>
    </ul> --}}

    {{-- <div id="navbarSearch" class="navbar-search w-100 collapse"> --}}
        {{-- <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
        --}}




        {{-- <div class="navbar-nav">
            @if (Auth::check())
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link px-3 border-0 text-white">Logout</a>
            </li>
            @endif
        </div> --}}

        <div class="navbar-nav ms-auto">
            @if (Auth::check())
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Selamat Datang, {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
            @endif
        </div>
</header>