<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
        aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Pengelolaan Surat</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="/dashboard">
                        <i class="bi bi-house-fill"></i>
                        Dashboard
                    </a>
                </li>
                @if (Auth::check())
                @if (Auth::user()->role == "staff")
                <li class="nav-item ">
                    <a class="nav-link {{ Request::is('users/satff*') ? 'active' : '' }}"
                        href="{{ route('users.indexSt') }}">
                        <i class="bi bi-people-fill"></i> Data Staff Tata Usaha
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ Request::is('/guru*') ? 'active' : '' }}" href="{{ route('users.indexGr') }}">
                        <i class="bi bi-people-fill"></i> Data Guru
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ Request::is('/guru*') ? 'active' : '' }}"
                        href="{{ route('lettertyp.index') }}">
                        <i class="bi bi-file-earmark-text"></i> Data Klasifikasi Surat
                    </a>
                </li>
                @endif
                @endif
             <li class="nav-item ">
                    <a class="nav-link {{ Request::is('/guru*') ? 'active' : '' }}" href="{{ route('letter.index') }}">
                        <i class="bi bi-file-earmark-text"></i> Data Surat
                    </a>
                </li>

               
      
            </ul>
        </div>
    </div>
</div>
<style>
    /* Warna latar belakang ketika aktif */
    .nav-item.active .nav-link {
        color: #2470dc;
        /* Warna teks ketika aktif */
    }

    /* Warna latar belakang ketika tidak aktif */
    .nav-item .nav-link {
        color: #000;
        /* Warna teks ketika tidak aktif */
    }
</style>