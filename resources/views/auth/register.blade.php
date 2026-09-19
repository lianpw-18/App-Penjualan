<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Pelanggan - Sansin Indonesia</title>
    <!-- Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --primary: #5f27cd;
            --primary-hover: #481b9e;
            --primary-light: #f3f0fb;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f3f0fb 0%, #f1f5f9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }
        .register-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 20px 50px rgba(95, 39, 205, 0.1);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #5f27cd 0%, #833ab4 100%);
            padding: 32px 24px;
            text-align: center;
            color: #ffffff;
        }
        .form-control-custom {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(95, 39, 205, 0.15);
        }
        .btn-register-submit {
            background: linear-gradient(135deg, #5f27cd 0%, #833ab4 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 12px;
            padding: 13px;
            border: none;
            width: 100%;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(95, 39, 205, 0.3);
        }
        .btn-register-submit:hover {
            background: linear-gradient(135deg, #481b9e 0%, #6c5ce7 100%);
            transform: translateY(-2px);
            color: #ffffff;
            box-shadow: 0 8px 25px rgba(95, 39, 205, 0.4);
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="register-header">
            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-3" style="width: 54px; height: 54px;">
                <i class="fa-solid fa-user-plus fs-4" style="color: var(--primary);"></i>
            </div>
            <h4 class="fw-bold mb-1">Daftar Akun Baru</h4>
            <p class="small mb-0 text-white-50">Nikmati kemudahan checkout produk gamis & pantau kurir pengiriman</p>
        </div>

        <div class="p-4 p-md-5">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="name" class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-user"></i></span>
                        <input id="name" type="text" class="form-control form-control-custom border-start-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Contoh: Siti Aisyah">
                    </div>
                    @error('name')
                        <div class="text-danger small mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-secondary">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-envelope"></i></span>
                        <input id="email" type="email" class="form-control form-control-custom border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold text-secondary">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-lock"></i></span>
                        <input id="password" type="password" class="form-control form-control-custom border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Minimal 4 karakter">
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-4">
                    <label for="password-confirm" class="form-label small fw-bold text-secondary">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-shield-halved"></i></span>
                        <input id="password-confirm" type="password" class="form-control form-control-custom border-start-0" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang kata sandi">
                    </div>
                </div>

                <button type="submit" class="btn btn-register-submit">
                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> DAFTAR SEKARANG
                </button>

                <div class="text-center mt-4 pt-3 border-top">
                    <span class="text-muted small">Sudah punya akun?</span>
                    <a href="{{ route('login') }}" class="fw-bold ms-1" style="color: var(--primary); text-decoration: none;">Masuk di sini</a>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ url('/') }}" class="text-muted small text-decoration-none">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Katalog Gamis
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
