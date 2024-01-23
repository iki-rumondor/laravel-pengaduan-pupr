<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        <a class="logo logo-front text-decoration-none d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('storage/logo-gorontalokota.png') }}" alt="">
            <span>Sistem Pengaduan</span>
        </a>
        <nav class="navbar ms-auto" id="navbar">
            <ul class="d-flex align-items-center">
                <li class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}"><i class="bi bi-house fs-6 me-2"></i>Beranda</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'index.pengaduan' || Route::currentRouteName() == 'create.pengaduan' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('index.pengaduan') }}"><i class="bi bi-clipboard-plus fs-6 me-2"></i>Pengaduan</a>
                </li>
                @if (auth()->user()->role == 'SUPER-ADMIN')
                    <li class="{{ Route::currentRouteName() == 'material.pengaduan' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('material.pengaduan') }}"><i class="bi bi-tools fs-6 me-2"></i>Material</a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'index.admin' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('index.admin') }}"><i class="bi bi-people fs-6 me-2"></i>Daftar Admin</a>
                    </li>
                @endif
                <li class="{{ Route::currentRouteName() == 'rekap.pengaduan' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('rekap.pengaduan') }}"><i class="bi bi-archive fs-6 me-2"></i>Rekapan</a>
                </li>
                <li class="ms-auto {{ Route::currentRouteName() == 'aduan.masyarakat.index' ? 'active' : '' }}">
                    @php($newAduan = auth()->user()->koarmat_id ? count(App\Models\Pengaduan::whereHas('wilayah', fn($wilayah) => $wilayah->where('koarmat_id', auth()->user()->koarmat_id))->where('dasar_pemeliharaan', null)->where('jenis', null)->get()) : count(App\Models\Pengaduan::where('dasar_pemeliharaan', null)->where('jenis', null)->get()))
                    @if($newAduan > 0)
                    <a class="nav-link position-relative" href="{{ route('aduan.masyarakat.index') }}">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $newAduan }}</span>
                    </a>
                    @endif
                </li>

                <li class="dropdown">
                    <a href="#">
                        <span>{{ auth()->user()->username }}</span> <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profil') }}">
                                <span>Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
    </div>
</header>