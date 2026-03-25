<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — DestiGuide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">

    <div class="auth-container">
        {{-- Brand --}}
        <div class="auth-brand">
            <img src="{{ asset('img/logo.png') }}" alt="DestiGuide">
            <h1>DESTIGUIDE</h1>
            <p>Nikmati liburan dengan mudah bersama kami</p>
        </div>

        {{-- Card --}}
        <div class="auth-card">
            <h2 class="auth-card-title">Masuk ke Akun</h2>
            <p class="auth-card-subtitle">Silakan isi email dan password Anda</p>

            {{-- Success Alert --}}
            @if(session('success'))
                <div class="auth-alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Alert --}}
            @if($errors->any())
                <div class="auth-alert-error">
                    <i class="bi bi-exclamation-circle-fill me-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control" name="email"
                           value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="auth-password-wrapper">
                        <input id="password" type="password" class="form-control" name="password"
                               placeholder="Masukkan password" required>
                        <button type="button" class="auth-password-toggle" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-auth mt-2">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>

            {{-- Register Link --}}
            <p class="auth-footer-text">
                Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
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
