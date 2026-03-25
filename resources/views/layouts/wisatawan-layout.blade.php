<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DestiGuide') — DestiGuide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/wisatawan.css') }}">
    @stack('styles')
</head>
<body class="wst-body">

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg wst-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <img src="{{ asset('img/logo.png') }}" alt="DestiGuide" width="40" height="40">
                <span class="text-white fw-bold d-none d-sm-inline" style="font-size:1.05rem;">DestiGuide</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#wstNav">
                <i class="bi bi-list text-white" style="font-size:1.5rem;"></i>
            </button>

            <div class="collapse navbar-collapse" id="wstNav">
                <ul class="navbar-nav me-auto ms-3">
                    <li class="nav-item">
                        <a class="nav-link-wst {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-compass me-1"></i> Jelajahi
                        </a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link-wst {{ request()->routeIs('history') ? 'active' : '' }}" href="{{ route('history') }}">
                            <i class="bi bi-clock-history me-1"></i> Riwayat
                        </a>
                    </li>
                    @endauth
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @auth
                    <div class="dropdown">
                        <button class="btn dropdown-toggle bg-transparent text-light d-flex align-items-center gap-2"
                                type="button" data-bs-toggle="dropdown">
                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-25"
                                 style="width:32px;height:32px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('history') }}"><i class="bi bi-clock-history me-2"></i>Riwayat</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="btn-wst-outline" style="padding:0.4rem 1rem;font-size:0.85rem;">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-wst" style="padding:0.4rem 1rem;font-size:0.85rem;">
                        <i class="bi bi-person-plus"></i> Daftar
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- CONTENT --}}
    <main class="main-content">
        {{-- ALERTS --}}
        @if(session('success') || session('error'))
        <div class="container" style="margin-top:1rem;">
            @if(session('success'))
                <div class="wst-alert-success" id="wstAlert">
                    <i class="bi bi-check-circle-fill" style="font-size:1.2rem;"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="wst-alert-error" id="wstAlert">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size:1.2rem;"></i>
                    {{ session('error') }}
                </div>
            @endif
        </div>
        @endif

        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="wst-footer">
        <div class="container">
            &copy; {{ date('Y') }} DestiGuide. All Rights Reserved.
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() { $('#wstAlert').fadeOut(400); }, 4000);

            // Navbar scroll effect
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 80) {
                    $('.wst-navbar').addClass('navbar-scrolled');
                } else {
                    $('.wst-navbar').removeClass('navbar-scrolled');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
