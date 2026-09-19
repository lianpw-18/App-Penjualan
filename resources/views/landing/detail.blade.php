<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->nm_barang }} | Sansin Indonesia</title>
    <meta name="description" content="{{ Str::limit($product->deskripsi, 150) }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #5f27cd;
            --primary-hover: #481b9e;
            --primary-light: #f3f0fb;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #2b2d42;
        }
        .navbar-custom {
            background: #ffffff;
            border-bottom: 1px solid #edf2f7;
            padding: 16px 0;
        }
        .navbar-brand-logo {
            font-weight: 800;
            font-size: 1.55rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .navbar-brand-logo i {
            font-size: 1.6rem;
            background: linear-gradient(135deg, #6c5ce7, #5f27cd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .product-detail-card {
            background: #ffffff;
            border-radius: 28px;
            border: 1px solid #edf2f7;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        }
        .btn-order-wa-lg {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: #ffffff;
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 30px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-order-wa-lg:hover {
            background: linear-gradient(135deg, #1ebe5d, #0b7367);
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand-logo" href="{{ url('/') }}">
                <i class="fa-solid fa-gem"></i>
                <span>Sansin <span style="color:#e65100;">Indonesia</span></span>
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="{{ url('/') }}#katalog" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Katalog
                </a>
                @auth
                    @if(auth()->user()->isPelanggan())
                        <a href="{{ route('customer.pesanan') }}" class="btn btn-outline-primary rounded-pill px-3">
                            <i class="fa-solid fa-box-archive me-1"></i> Status Pesanan
                        </a>
                        <a href="{{ route('customer.profile') }}" class="btn btn-outline-primary rounded-pill px-3">
                            <i class="fa-solid fa-user-gear me-1"></i> Profil Saya
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill px-3">
                            <i class="fa-solid fa-cash-register me-1"></i> Dashboard POS
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-3">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-3" style="background: linear-gradient(135deg, #6c5ce7, #5f27cd); border: none;">
                        <i class="fa-solid fa-user-plus me-1"></i> Daftar
                    </a>
                    <a href="{{ route('login.admin') }}" class="btn btn-warning rounded-pill px-3 fw-bold" style="background-color: #f59e0b; border: none; color: #1e293b;">
                        <i class="fa-solid fa-cash-register me-1"></i> Login POS
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Detail Section -->
    <div class="container py-5">
        <div class="product-detail-card mb-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 text-center">
                    <div class="rounded-4 overflow-hidden shadow-sm bg-light">
                        <img src="https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=700&q=80" alt="{{ $product->nm_barang }}" class="img-fluid w-100" style="max-height: 480px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-danger rounded-pill px-3 py-2">{{ $product->kategori ? $product->kategori->kategori : 'Gamis' }}</span>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">Kode: {{ $product->kd_penjualan_barang }}</span>
                        @if($product->diskon_persen > 0)
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Hemat {{ number_format($product->diskon_persen, 0) }}%</span>
                        @endif
                    </div>

                    <h1 class="fw-bold text-dark mb-3 fs-2">{{ $product->nm_barang }}</h1>

                    <div class="d-flex align-items-center gap-2 mb-4">
                        <div class="text-warning">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="text-muted small">5.0 (48 ulasan terverifikasi)</span>
                    </div>

                    <!-- Price Box -->
                    <div class="p-4 bg-light rounded-4 mb-4">
                        <span class="text-muted small d-block mb-1">Harga Resmi:</span>
                        <div class="d-flex align-items-baseline gap-3">
                            @if($product->diskon_persen > 0)
                                <h2 class="fw-bold text-danger mb-0">{{ $product->formatted_harga_setelah_diskon }}</h2>
                                <h5 class="text-muted text-decoration-line-through mb-0">{{ $product->formatted_harga_jual }}</h5>
                            @else
                                <h2 class="fw-bold text-danger mb-0">{{ $product->formatted_harga_jual }}</h2>
                            @endif
                        </div>
                        <div class="mt-2 text-muted small">
                            Stok Saat Ini: <strong class="text-success">{{ $product->stok }} {{ $product->satuan ? $product->satuan->satuan : 'Pcs' }}</strong> (Siap Kirim)
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-2">Deskripsi Produk:</h5>
                        <p class="text-muted lh-base">{{ $product->deskripsi ?: 'Gamis dan busana muslimah syar\'i berkualitas butik premium. Nyaman dan adem dipakai seharian.' }}</p>
                    </div>

                    @php
                        $priceToOrder = $product->diskon_persen > 0 ? $product->formatted_harga_setelah_diskon : $product->formatted_harga_jual;
                        $waText = urlencode("Halo Admin Sansin Indonesia, saya ingin memesan:\n\n*Nama Produk:* {$product->nm_barang}\n*Kode:* {$product->kd_penjualan_barang}\n*Harga:* {$priceToOrder}\n\nMohon petunjuk pemesanan dan ongkir. Terima kasih.");
                    @endphp

                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <a href="javascript:void(0)" onclick="proceedToCheckout('{{ route('checkout.index', ['product_id' => $product->id, 'qty' => 1]) }}')" class="btn btn-success btn-lg rounded-pill px-4 py-3 fw-bold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #03ac0e; border: none;">
                            <i class="fa-solid fa-bolt"></i> Beli Langsung (Web Tokopedia Style)
                        </a>
                        <a href="https://wa.me/6281234567890?text={{ $waText }}" target="_blank" class="btn-order-wa-lg">
                            <i class="fa-brands fa-whatsapp fs-4"></i> Beli via WhatsApp
                        </a>
                        <a href="{{ url('/') }}#katalog" class="btn btn-light rounded-pill px-4 py-3 fw-bold border">
                            Lihat Produk Lain
                        </a>
                    </div>

                </div>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
            <div class="mt-5">
                <h4 class="fw-bold mb-4">Produk Serupa Lainnya</h4>
                <div class="row g-4">
                    @foreach($relatedProducts as $rel)
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                                <h6 class="fw-bold mb-1">{{ $rel->nm_barang }}</h6>
                                <p class="text-danger fw-bold mb-3">{{ $rel->formatted_harga_jual }}</p>
                                <a href="{{ route('katalog.detail', $rel->id) }}" class="btn btn-outline-primary btn-sm rounded-pill mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const IS_AUTHENTICATED = {{ auth()->check() ? 'true' : 'false' }};
        const LOGIN_PAGE_URL = "{{ route('login') }}";

        function proceedToCheckout(targetUrl) {
            if (!IS_AUTHENTICATED) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Silakan Masuk Terlebih Dahulu',
                    text: 'Untuk melanjutkan proses pembelian & checkout, Anda perlu masuk ke akun pelanggan atau membuat akun baru.',
                    showCancelButton: true,
                    confirmButtonColor: '#5f27cd',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fa-solid fa-right-to-bracket me-1"></i> Masuk Sekarang',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = LOGIN_PAGE_URL;
                    }
                });
                return false;
            }

            window.location.href = targetUrl;
            return true;
        }
    </script>
</body>
</html>
