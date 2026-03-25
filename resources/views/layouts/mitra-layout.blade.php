<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mitra Dashboard') — DestiGuide</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- DataTables --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    {{-- Mitra CSS --}}
    <link rel="stylesheet" href="{{ asset('css/mitra.css') }}">

    @stack('styles')
</head>

<body class="mitra-body">

    {{-- ========== NAVBAR ========== --}}
    <nav class="navbar navbar-expand-lg mitra-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('mitra') }}">
                <img src="{{ asset('img/logo.png') }}" alt="DestiGuide" width="42" height="42">
                <span class="text-white fw-bold d-none d-md-inline" style="font-size:1.1rem;">DestiGuide</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mitraNav" aria-controls="mitraNav" aria-expanded="false">
                <i class="bi bi-list text-white" style="font-size:1.5rem;"></i>
            </button>

            <div class="collapse navbar-collapse" id="mitraNav">
                <ul class="navbar-nav me-auto ms-3">
                    <li class="nav-item">
                        <a class="nav-link-mitra {{ request()->routeIs('mitra') ? 'active' : '' }}" href="{{ route('mitra') }}">
                            <i class="bi bi-house-door me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-mitra {{ request()->routeIs('viewWisata') ? 'active' : '' }}" href="{{ route('viewWisata') }}">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Wisata
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-mitra {{ request()->routeIs('kelolaWisata') ? 'active' : '' }}" href="{{ route('kelolaWisata') }}">
                            <i class="bi bi-gear me-1"></i> Kelola Wisata
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    @auth
                    <div class="dropdown">
                        <button class="btn dropdown-toggle bg-transparent text-light d-flex align-items-center gap-2"
                                type="button" id="mitraUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-25"
                                 style="width:32px;height:32px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mitraUserDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
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
                    <a class="nav-link-mitra" href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ========== ALERTS ========== --}}
    <div class="container mt-3">
        @if(session('success'))
            <div class="mitra-alert-success" id="mitraAlert">
                <i class="bi bi-check-circle-fill" style="font-size:1.2rem;"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mitra-alert-error" id="mitraAlert">
                <i class="bi bi-exclamation-triangle-fill" style="font-size:1.2rem;"></i>
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- ========== MAIN CONTENT ========== --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- ========== FOOTER ========== --}}
    <footer class="mitra-footer">
        <div class="container">
            &copy; {{ date('Y') }} DestiGuide. All Rights Reserved.
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    {{-- Auto-hide alerts --}}
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#mitraAlert').fadeOut(400);
            }, 4000);
        });
    </script>

    @stack('scripts')
</body>

</html>
