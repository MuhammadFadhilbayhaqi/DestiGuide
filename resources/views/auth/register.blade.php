<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — DestiGuide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">

    <div class="auth-container auth-container-wide">
        {{-- Brand --}}
        <div class="auth-brand">
            <img src="{{ asset('img/logo.png') }}" alt="DestiGuide">
            <h1>DESTIGUIDE</h1>
            <p>Buat akun dan mulai jelajahi wisata Indonesia</p>
        </div>

        {{-- Card --}}
        <div class="auth-card">
            <h2 class="auth-card-title">Buat Akun Baru</h2>
            <p class="auth-card-subtitle">Isi data di bawah untuk mendaftar</p>

            {{-- Errors --}}
            @if($errors->any())
                <div class="auth-alert-error">
                    <i class="bi bi-exclamation-circle-fill me-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" type="text" class="form-control" name="name"
                           value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control" name="email"
                           value="{{ old('email') }}" placeholder="nama@email.com" required>
                </div>

                {{-- Phone --}}
                <div class="mb-3">
                    <label for="handphone" class="form-label">No. Handphone</label>
                    <input id="handphone" type="tel" class="form-control" name="handphone"
                           value="{{ old('handphone') }}" placeholder="Contoh: 08123456789" required>
                </div>

                {{-- Passwords --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <div class="auth-password-wrapper">
                            <input id="password" type="password" class="form-control" name="password"
                                   placeholder="Min. 8 karakter" required>
                            <button type="button" class="auth-password-toggle" onclick="togglePassword('password', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Ulangi Password</label>
                        <div class="auth-password-wrapper">
                            <input id="password_confirmation" type="password" class="form-control"
                                   name="password_confirmation" placeholder="Ketik ulang password" required>
                            <button type="button" class="auth-password-toggle" onclick="togglePassword('password_confirmation', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label class="form-label">Daftar Sebagai</label>
                    <div class="auth-role-selector">
                        <div class="auth-role-option">
                            <input type="radio" name="role" id="roleWisatawan" value="Wisatawan"
                                   {{ old('role', 'Wisatawan') == 'Wisatawan' ? 'checked' : '' }} required>
                            <label for="roleWisatawan">
                                <i class="bi bi-person-walking"></i>
                                <span>Wisatawan</span>
                                <small>Cari & pesan wisata</small>
                            </label>
                        </div>
                        <div class="auth-role-option">
                            <input type="radio" name="role" id="roleMitra" value="Mitra"
                                   {{ old('role') == 'Mitra' ? 'checked' : '' }}>
                            <label for="roleMitra">
                                <i class="bi bi-building"></i>
                                <span>Mitra</span>
                                <small>Kelola tempat wisata</small>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-auth">
                    <i class="bi bi-person-plus"></i> Daftar
                </button>
            </form>

            {{-- Login Link --}}
            <p class="auth-footer-text">
                Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
            </p>
        </div>

        <p class="auth-copyright">&copy; {{ date('Y') }} DestiGuide. All Rights Reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>
</html>
