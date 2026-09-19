<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Sansin Indonesia</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #5f27cd;
            --primary-hover: #481b9e;
            --primary-light: #f3f0fb;
            --tokopedia-green: #03ac0e;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            padding-bottom: 60px;
        }
        .navbar-custom {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 0;
        }
        .navbar-brand-logo {
            font-weight: 800;
            font-size: 1.45rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .navbar-brand-logo i {
            font-size: 1.55rem;
            background: linear-gradient(135deg, #6c5ce7, #5f27cd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .portal-nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.92rem;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .portal-nav-link:hover {
            color: var(--primary);
            background-color: var(--primary-light);
        }
        .portal-nav-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, #6c5ce7, #5f27cd);
            box-shadow: 0 4px 12px rgba(95, 39, 205, 0.25);
        }

        .profile-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
            padding: 28px;
            margin-bottom: 24px;
        }
        .profile-header-card {
            background: linear-gradient(135deg, #5f27cd 0%, #341f97 100%);
            border-radius: 24px;
            padding: 32px;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(95, 39, 205, 0.25);
            margin-bottom: 28px;
        }
        .profile-header-card::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -60px;
            right: -40px;
            pointer-events: none;
        }
        .avatar-circle {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            font-weight: 800;
            color: #ffffff;
            backdrop-filter: blur(4px);
        }
        .stat-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            padding: 14px 20px;
            text-align: center;
            color: #fff;
        }
        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-label {
            font-size: 0.78rem;
            opacity: 0.85;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
        }
        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            font-size: 0.92rem;
            transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(95, 39, 205, 0.15);
        }
        .btn-primary-purple {
            background: linear-gradient(135deg, #6c5ce7, #5f27cd);
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 12px;
            padding: 10px 24px;
            box-shadow: 0 4px 14px rgba(95, 39, 205, 0.25);
            transition: all 0.2s;
        }
        .btn-primary-purple:hover {
            background: linear-gradient(135deg, #5844e0, #481b9e);
            color: #fff;
            transform: translateY(-1px);
        }
        .section-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>

    <!-- Top Navbar with 3 Dedicated Portals: Beranda (Katalog), Status Pesanan, Profil -->
    <header class="navbar-custom sticky-top">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="navbar-brand-logo" href="{{ url('/') }}">
                <i class="fa-solid fa-gem"></i>
                <span>Sansin <span style="color:#e65100;">Indonesia</span></span>
            </a>

            <!-- Central Navigation Menu (Beranda, Status Pesanan, Profile) -->
            <nav class="d-none d-md-flex align-items-center gap-2">
                <a href="{{ url('/') }}" class="portal-nav-link">
                    <i class="fa-solid fa-store"></i> Beranda (Katalog)
                </a>
                <a href="{{ route('customer.pesanan') }}" class="portal-nav-link">
                    <i class="fa-solid fa-box-archive"></i> Status Pesanan
                </a>
                <a href="{{ route('customer.profile') }}" class="portal-nav-link active">
                    <i class="fa-solid fa-user-gear"></i> Profil Saya
                </a>
            </nav>

            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill px-3 py-1 btn-sm fw-semibold dropdown-toggle d-flex align-items-center gap-2 border" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-circle-user text-primary fs-5"></i>
                        <span class="d-none d-sm-inline">{{ strtok(Auth::user()->name, ' ') }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 py-2">
                        <li class="px-3 py-1 text-muted small border-bottom mb-1">
                            Akun: <strong>{{ Auth::user()->email }}</strong>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-md-none" href="{{ url('/') }}">
                                <i class="fa-solid fa-store me-2 text-secondary"></i> Beranda (Katalog)
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-md-none" href="{{ route('customer.pesanan') }}">
                                <i class="fa-solid fa-box-archive me-2 text-primary"></i> Status Pesanan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-md-none active" href="{{ route('customer.profile') }}">
                                <i class="fa-solid fa-user-gear me-2 text-primary"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('customer.pesanan') }}">
                                <i class="fa-solid fa-receipt me-2 text-success"></i> Riwayat Belanja
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="d-none d-sm-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" title="Keluar">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Sub-Navbar for Mobile (Shows 3 main tabs horizontally) -->
    <div class="bg-white border-bottom py-2 d-md-none">
        <div class="container d-flex justify-content-around">
            <a href="{{ url('/') }}" class="portal-nav-link text-center px-2 py-1" style="font-size: 0.82rem;">
                <i class="fa-solid fa-store"></i> Beranda
            </a>
            <a href="{{ route('customer.pesanan') }}" class="portal-nav-link text-center px-2 py-1" style="font-size: 0.82rem;">
                <i class="fa-solid fa-box-archive"></i> Status Pesanan
            </a>
            <a href="{{ route('customer.profile') }}" class="portal-nav-link active text-center px-2 py-1" style="font-size: 0.82rem;">
                <i class="fa-solid fa-user-gear"></i> Profil
            </a>
        </div>
    </div>

    <div class="container mt-4">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <div class="fw-bold mb-1"><i class="fa-solid fa-circle-exclamation me-2"></i> Terjadi kesalahan:</div>
                <ul class="mb-0 ps-3 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Profile Hero Header Banner -->
        <div class="profile-header-card">
            <div class="row align-items-center g-4">
                <div class="col-md-7 d-flex align-items-center gap-3">
                    <div class="avatar-circle flex-shrink-0">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <span class="badge bg-white text-primary fw-bold px-3 py-1 rounded-pill small">
                                <i class="fa-solid fa-shield-halved me-1"></i> Pelanggan Terdaftar
                            </span>
                            <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill small">
                                <i class="fa-solid fa-crown me-1"></i> Member Syar'i
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1 text-white">{{ $user->name }}</h3>
                        <div class="text-white-50 small d-flex align-items-center gap-3 flex-wrap">
                            <span><i class="fa-solid fa-envelope me-1"></i> {{ $user->email }}</span>
                            @if($user->no_hp)
                                <span><i class="fa-brands fa-whatsapp me-1"></i> {{ $user->no_hp }}</span>
                            @endif
                            <span><i class="fa-solid fa-calendar-days me-1"></i> Bergabung: {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row g-2">
                        <div class="col-4">
                            <div class="stat-badge">
                                <div class="stat-number">{{ $totalPesanan }}</div>
                                <div class="stat-label">Total Order</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-badge">
                                <div class="stat-number">{{ $pesananAktif }}</div>
                                <div class="stat-label">Berjalan</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-badge">
                                <div class="stat-number">{{ $pesananSelesai }}</div>
                                <div class="stat-label">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Informasi Profil & Alamat -->
            <div class="col-lg-7">
                <div class="profile-card">
                    <div class="section-title">
                        <i class="fa-solid fa-id-card text-primary"></i>
                        <span>Informasi Akun & Pengiriman Utama</span>
                    </div>

                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="name">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="email">Alamat Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="no_hp">Nomor WhatsApp / HP</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="fa-brands fa-whatsapp text-success"></i></span>
                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 081234567890">
                                </div>
                                @error('no_hp')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="alamat">Alamat Lengkap Pengiriman</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Nama Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota & Kode Pos">{{ old('alamat', $user->alamat) }}</textarea>
                            <div class="text-muted small mt-1">Alamat ini dapat digunakan otomatis saat Anda checkout pesanan gamis & abaya berikutnya.</div>
                            @error('alamat')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary-purple">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan Profil
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Column: Keamanan & Quick Shortcuts -->
            <div class="col-lg-5">
                <!-- Ubah Password -->
                <div class="profile-card mb-4">
                    <div class="section-title">
                        <i class="fa-solid fa-lock text-primary"></i>
                        <span>Keamanan / Ganti Password</span>
                    </div>

                    <form action="{{ route('customer.profile.password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="current_password">Password Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required placeholder="Masukkan password lama">
                            @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimal 6 karakter">
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password baru">
                        </div>

                        <button type="submit" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                            <i class="fa-solid fa-key me-1"></i> Perbarui Password
                        </button>
                    </form>
                </div>

                <!-- Bantuan & Quick Links -->
                <div class="profile-card">
                    <div class="section-title">
                        <i class="fa-solid fa-circle-question text-primary"></i>
                        <span>Bantuan & Layanan Pelanggan</span>
                    </div>
                    <p class="text-muted small">
                        Punya pertanyaan mengenai pesanan, konsultasi ukuran gamis syar'i, atau pelacakan ekspedisi? Tim CS kami siap melayani Anda.
                    </p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('customer.pesanan') }}" class="btn btn-light text-start py-2 px-3 rounded-3 border d-flex align-items-center justify-content-between text-decoration-none">
                            <span class="fw-semibold small"><i class="fa-solid fa-box-archive text-primary me-2"></i> Cek Status Pesanan Saya</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-light text-start py-2 px-3 rounded-3 border d-flex align-items-center justify-content-between text-decoration-none">
                            <span class="fw-semibold small"><i class="fa-solid fa-store text-success me-2"></i> Belanja Koleksi Gamis Terbaru</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Butik,%20saya%20ingin%20bertanya%20mengenai%20pesanan%20saya" target="_blank" class="btn btn-success text-white py-2 px-3 rounded-3 fw-bold small text-decoration-none text-center mt-2">
                            <i class="fa-brands fa-whatsapp me-1"></i> Chat WhatsApp Customer Service
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
