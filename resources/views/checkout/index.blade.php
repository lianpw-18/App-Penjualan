<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan - Sansin Indonesia</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary: #5f27cd;
            --primary-hover: #481b9e;
            --primary-light: #f3f0fb;
            --tokopedia-green: #03ac0e;
            --tokopedia-green-hover: #028e0b;
            --text-dark: #212529;
            --text-muted: #6c757d;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f6f9;
            color: var(--text-dark);
            padding-bottom: 60px;
        }

        /* Top Header */
        .checkout-header {
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .brand-logo {
            font-weight: 800;
            font-size: 1.45rem;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-logo i {
            font-size: 1.55rem;
            background: linear-gradient(135deg, #6c5ce7, #5f27cd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Checkout Card */
        .checkout-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #eef0f3;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            padding: 24px;
            margin-bottom: 20px;
        }
        .checkout-card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .checkout-card-title i {
            color: var(--primary);
        }

        /* Product Item Row */
        .product-checkout-item {
            display: flex;
            gap: 16px;
            padding: 14px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .product-checkout-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .product-checkout-img {
            width: 72px;
            height: 72px;
            border-radius: 12px;
            object-fit: cover;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.5rem;
            flex-shrink: 0;
            border: 1px solid #edf2f7;
        }

        /* Courier Option Card */
        .courier-option {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .courier-option:hover {
            border-color: #cbd5e1;
            background-color: #f8fafc;
        }
        .courier-option.selected {
            border-color: var(--tokopedia-green);
            background-color: #f0fdf4;
        }

        /* Payment Option Card */
        .payment-option {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .payment-option:hover {
            border-color: #cbd5e1;
            background-color: #f8fafc;
        }
        .payment-option.selected {
            border-color: var(--primary);
            background-color: var(--primary-light);
        }

        /* Sticky Summary Box */
        .summary-sticky {
            position: sticky;
            top: 90px;
        }
        .btn-pay-tokopedia {
            background-color: var(--tokopedia-green);
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            padding: 14px;
            border-radius: 12px;
            border: none;
            width: 100%;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(3, 172, 14, 0.25);
        }
        .btn-pay-tokopedia:hover {
            background-color: var(--tokopedia-green-hover);
            color: #fff;
            transform: translateY(-2px);
        }
        .btn-pay-tokopedia:disabled {
            background-color: #94a3b8;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="checkout-header">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="brand-logo">
                <i class="fa-solid fa-gem"></i>
                <span>Sansin <span style="color:#e65100;">Indonesia</span></span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    <i class="fa-solid fa-lock text-success me-1"></i> Checkout Aman & Terpercaya
                </span>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm rounded-pill ms-2">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Toko
                </a>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row g-4">
            
            <!-- Left Column: Checkout Details -->
            <div class="col-lg-8">
                
                <!-- 1. Alamat Pengiriman -->
                <div class="checkout-card">
                    <div class="checkout-card-title">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>1. Alamat Pengiriman</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" id="recipientName" class="form-control" placeholder="Nama lengkap penerima" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                            <input type="tel" id="recipientPhone" class="form-control" placeholder="081234567890" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Provinsi Tujuan <span class="text-danger">*</span></label>
                            <select id="provinceSelect" class="form-select" onchange="onProvinceChange()">
                                @foreach($provinces as $p)
                                    <option value="{{ $p->code }}" data-name="{{ $p->name }}" {{ $p->name === 'JAWA TENGAH' ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Kota / Kabupaten <span class="text-danger">*</span></label>
                            <select id="citySelect" class="form-select" onchange="onCityChange()">
                                <option value="">-- Memuat Kota / Kabupaten... --</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Kecamatan <span class="text-danger">*</span></label>
                            <select id="districtSelect" class="form-select" onchange="onDistrictChange()">
                                <option value="">-- Memuat Kecamatan... --</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Kelurahan / Desa <span class="text-danger">*</span></label>
                            <select id="villageSelect" class="form-select" onchange="onVillageChange()">
                                <option value="">-- Memuat Kelurahan / Desa... --</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label small fw-bold">Alamat Lengkap (Jalan, RT/RW, No. Rumah, Patokan) <span class="text-danger">*</span></label>
                            <textarea id="fullAddress" class="form-control" rows="2" placeholder="Contoh: Jl. Diponegoro No. 45 RT 02/RW 04 (sebelah Masjid)" required></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Kode Pos</label>
                            <input type="text" id="postalCode" class="form-control" placeholder="54111">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Catatan Pengiriman (Opsional)</label>
                            <input type="text" id="orderNotes" class="form-control" placeholder="Warna cadangan atau titipkan di pos satpam">
                        </div>
                    </div>
                </div>

                <!-- 2. Ringkasan Barang yang Dibeli -->
                <div class="checkout-card">
                    <div class="checkout-card-title justify-content-between">
                        <div>
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span>2. Produk yang Dibeli</span>
                        </div>
                        <span class="badge bg-light text-muted border fw-normal" id="itemCountBadge">1 Barang</span>
                    </div>

                    <div id="checkoutProductList">
                        <!-- Product items rendered dynamically via JS -->
                    </div>
                </div>

                <!-- 3. Pilihan Ekspedisi & Ongkir (Tokopedia Style) -->
                <div class="checkout-card">
                    <div class="checkout-card-title justify-content-between">
                        <div>
                            <i class="fa-solid fa-truck-fast"></i>
                            <span>3. Pilih Ekspedisi & Pengiriman</span>
                        </div>
                        <span class="text-muted small" id="shippingWeight">Estimasi Berat: 1 kg</span>
                    </div>

                    <div id="courierLoading" class="text-center py-3 text-muted">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                        <span>Menghitung ongkos kirim terbaik...</span>
                    </div>

                    <div id="courierOptionsContainer" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted mb-1">
                                <i class="fa-solid fa-truck-ramp-box me-1"></i> Pilih Ekspedisi & Layanan:
                            </label>
                            <select id="courierSelect" class="form-select form-select-lg" style="font-size: 0.95rem;" onchange="onCourierSelectChange(this.value)">
                                <!-- Populated dynamically -->
                            </select>
                        </div>

                        <!-- Compact Highlight of Selected Courier -->
                        <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between" id="selectedCourierPreview" style="background-color: #f0fdf4; border-color: #86efac !important;">
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-success px-3 py-2 fw-bold fs-6" id="previewCourierCode">JNE</span>
                                <div>
                                    <div class="fw-bold text-dark" id="previewCourierService">JNE REG (Reguler)</div>
                                    <div class="small text-muted" id="previewCourierEtd">
                                        <i class="fa-solid fa-clock me-1 text-success"></i> Estimasi tiba: 1-3 Hari
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success fs-5" id="previewCourierCost">Rp 9.000</div>
                                <span class="badge bg-light text-muted border small">Tarif Resmi</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Metode Pembayaran -->
                <div class="checkout-card">
                    <div class="checkout-card-title">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>4. Pilih Metode Pembayaran</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted mb-1">
                            <i class="fa-solid fa-wallet me-1"></i> Metode Pembayaran:
                        </label>
                        <select id="paymentSelect" class="form-select form-select-lg" style="font-size: 0.95rem;" onchange="onPaymentSelectChange(this.value)">
                            <optgroup label="Transfer Bank (Verifikasi Manual / Otomatis)">
                                <option value="transfer_bca" selected>Transfer Bank BCA</option>
                                <option value="transfer_mandiri">Transfer Bank Mandiri</option>
                                <option value="transfer_bri">Transfer Bank BRI</option>
                            </optgroup>
                            <optgroup label="Uang Elektronik / E-Wallet">
                                <option value="qris">QRIS (GoPay, OVO, Dana, ShopeePay, LinkAja)</option>
                            </optgroup>
                            <optgroup label="Bayar di Tempat">
                                <option value="cod">COD (Bayar Tunai ke Kurir Saat Paket Sampai)</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- Compact Highlight of Selected Payment -->
                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between" id="selectedPaymentPreview" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div id="previewPaymentIcon" class="fs-4 text-primary">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark" id="previewPaymentTitle">Transfer Bank BCA</div>
                                <div class="small text-muted" id="previewPaymentDesc">Verifikasi transfer manual / otomatis via m-BCA atau ATM BCA</div>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small">Tersedia</span>
                    </div>
                </div>

            </div>

            <!-- Right Column: Sticky Summary & Pay Button -->
            <div class="col-lg-4">
                <div class="checkout-card summary-sticky">
                    <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Harga Barang</span>
                        <span class="fw-semibold" id="summarySubtotal">Rp 0</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-success" id="summaryDiskonRow" style="display: none;">
                        <span>Diskon Produk</span>
                        <span class="fw-semibold" id="summaryDiskon">- Rp 0</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2" id="summaryPpnRow">
                        <span class="text-muted">PPN (11%)</span>
                        <span class="fw-semibold" id="summaryPpn">Rp 0</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Ongkos Kirim</span>
                        <span class="fw-semibold text-primary" id="summaryOngkir">Pilih Kurir</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <div class="small text-muted">Total Tagihan</div>
                            <div class="fw-bold fs-4 text-dark" id="summaryGrandTotal">Rp 0</div>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small">
                            <i class="fa-solid fa-shield-check me-1"></i> Terjamin
                        </span>
                    </div>

                    <button type="button" class="btn-pay-tokopedia mb-3" id="btnSubmitOrder" onclick="processOrder()">
                        <i class="fa-solid fa-lock me-2"></i> Bayar Sekarang
                    </button>

                    <div class="text-center">
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Sansin%20Indonesia,%20saya%20butuh%20bantuan%20untuk%20checkout%20di%20website." target="_blank" class="text-decoration-none small text-success fw-semibold">
                            <i class="fa-brands fa-whatsapp me-1"></i> Tanya Admin via WhatsApp
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const directProduct = @json($directProduct);
        const directQty = {{ $singleQty }};
        const ppnEnabled = {{ ($setting && $setting->ppn_enabled) ? 'true' : 'false' }};
        const ppnPersen = {{ ($setting && $setting->ppn_enabled) ? ($setting->ppn_presentase ?? 11) : 0 }};

        let checkoutItems = [];
        let selectedCourier = null;
        let selectedPayment = 'transfer_bca';

        // Initialize Page
        document.addEventListener('DOMContentLoaded', () => {
            initAddressCascade();
            initCheckoutItems();
        });

        async function initAddressCascade() {
            await onProvinceChange();
        }

        async function onProvinceChange() {
            const provSelect = document.getElementById('provinceSelect');
            const citySelect = document.getElementById('citySelect');
            const districtSelect = document.getElementById('districtSelect');
            const villageSelect = document.getElementById('villageSelect');

            const provCode = provSelect.value;
            citySelect.innerHTML = '<option value="">-- Memuat Kota / Kabupaten... --</option>';
            districtSelect.innerHTML = '<option value="">-- Pilih Kota Terlebih Dahulu --</option>';
            villageSelect.innerHTML = '<option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>';

            try {
                const res = await fetch(`{{ route('checkout.cities') }}?province_code=${provCode}`);
                const cities = await res.json();
                
                citySelect.innerHTML = '';
                if (cities.length === 0) {
                    citySelect.innerHTML = '<option value="">-- Tidak ada kota --</option>';
                    return;
                }

                // Default preferred city in Central Java: PURWOREJO if available
                let selectedCityCode = cities[0].code;
                const purworejo = cities.find(c => c.name.toUpperCase().includes('PURWOREJO'));
                if (purworejo) {
                    selectedCityCode = purworejo.code;
                }

                cities.forEach(city => {
                    const opt = document.createElement('option');
                    opt.value = city.code;
                    opt.setAttribute('data-name', city.name);
                    opt.textContent = city.name;
                    if (city.code === selectedCityCode) opt.selected = true;
                    citySelect.appendChild(opt);
                });

                await onCityChange();
            } catch (err) {
                console.error(err);
                citySelect.innerHTML = '<option value="">-- Gagal memuat data kota --</option>';
            }
        }

        async function onCityChange() {
            const citySelect = document.getElementById('citySelect');
            const districtSelect = document.getElementById('districtSelect');
            const villageSelect = document.getElementById('villageSelect');

            const cityCode = citySelect.value;
            districtSelect.innerHTML = '<option value="">-- Memuat Kecamatan... --</option>';
            villageSelect.innerHTML = '<option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>';

            fetchShippingRates();

            if (!cityCode) return;

            try {
                const res = await fetch(`{{ route('checkout.districts') }}?city_code=${cityCode}`);
                const districts = await res.json();

                districtSelect.innerHTML = '';
                if (districts.length === 0) {
                    districtSelect.innerHTML = '<option value="">-- Tidak ada kecamatan --</option>';
                    return;
                }

                districts.forEach((d, idx) => {
                    const opt = document.createElement('option');
                    opt.value = d.code;
                    opt.setAttribute('data-name', d.name);
                    opt.textContent = d.name;
                    if (idx === 0) opt.selected = true;
                    districtSelect.appendChild(opt);
                });

                await onDistrictChange();
            } catch (err) {
                console.error(err);
                districtSelect.innerHTML = '<option value="">-- Gagal memuat kecamatan --</option>';
            }
        }

        async function onDistrictChange() {
            const districtSelect = document.getElementById('districtSelect');
            const villageSelect = document.getElementById('villageSelect');
            const districtCode = districtSelect.value;

            villageSelect.innerHTML = '<option value="">-- Memuat Kelurahan / Desa... --</option>';

            if (!districtCode) return;

            try {
                const res = await fetch(`{{ route('checkout.villages') }}?district_code=${districtCode}`);
                const villages = await res.json();

                villageSelect.innerHTML = '';
                if (villages.length === 0) {
                    villageSelect.innerHTML = '<option value="">-- Tidak ada kelurahan --</option>';
                    return;
                }

                villages.forEach((v, idx) => {
                    const opt = document.createElement('option');
                    opt.value = v.code;
                    opt.setAttribute('data-name', v.name);
                    const posCode = v.meta && v.meta.pos ? v.meta.pos : '';
                    opt.setAttribute('data-pos', posCode);
                    opt.textContent = posCode ? `${v.name} (${posCode})` : v.name;
                    if (idx === 0) opt.selected = true;
                    villageSelect.appendChild(opt);
                });

                onVillageChange();
            } catch (err) {
                console.error(err);
                villageSelect.innerHTML = '<option value="">-- Gagal memuat kelurahan --</option>';
            }
        }

        function onVillageChange() {
            const villageSelect = document.getElementById('villageSelect');
            const selectedOpt = villageSelect.options[villageSelect.selectedIndex];
            if (selectedOpt) {
                const pos = selectedOpt.getAttribute('data-pos');
                if (pos) {
                    const postalInput = document.getElementById('postalCode');
                    if (postalInput) postalInput.value = pos;
                }
            }
        }

        function initCheckoutItems() {
            if (directProduct) {
                // Direct checkout single item
                checkoutItems = [{
                    id: directProduct.id,
                    name: directProduct.nm_barang,
                    price: parseFloat(directProduct.harga_jual),
                    discount: parseFloat(directProduct.diskon_persen || 0),
                    qty: directQty,
                    stock: directProduct.stok
                }];
            } else {
                // Read from LocalStorage cart
                const cartData = localStorage.getItem('butik_cart');
                if (cartData) {
                    try {
                        checkoutItems = JSON.parse(cartData);
                    } catch (e) {
                        checkoutItems = [];
                    }
                }
            }

            if (!checkoutItems || checkoutItems.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Keranjang Kosong',
                    text: 'Silakan pilih produk gamis terlebih dahulu.',
                    confirmButtonColor: '#9b1b4a',
                }).then(() => {
                    window.location.href = "{{ url('/') }}";
                });
                return;
            }

            renderProductList();
            updateCalculations();
        }

        function renderProductList() {
            const container = document.getElementById('checkoutProductList');
            const badge = document.getElementById('itemCountBadge');
            let totalQty = 0;

            container.innerHTML = '';
            checkoutItems.forEach((item, index) => {
                totalQty += item.qty;
                const hargaSetelahDiskon = item.price - (item.price * (item.discount / 100));

                const itemHtml = `
                    <div class="product-checkout-item">
                        <div class="product-checkout-img">
                            <i class="fa-solid fa-shirt"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark">${item.name}</div>
                            <div class="text-muted small">Jumlah: <strong>${item.qty} pcs</strong></div>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <span class="fw-bold text-dark">Rp ${formatNumber(hargaSetelahDiskon * item.qty)}</span>
                                ${item.discount > 0 ? `<span class="badge bg-danger-subtle text-danger small">Diskon ${item.discount}%</span>` : ''}
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += itemHtml;
            });

            badge.textContent = `${totalQty} Barang`;
            document.getElementById('shippingWeight').textContent = `Estimasi Berat: ${Math.max(1, Math.ceil(totalQty * 0.4))} kg`;
        }

        // Fetch Shipping Rates from server
        function fetchShippingRates() {
            const provSelect = document.getElementById('provinceSelect');
            const citySelect = document.getElementById('citySelect');
            if (!provSelect || !citySelect) return;

            const provName = provSelect.options[provSelect.selectedIndex]?.getAttribute('data-name') || provSelect.value;
            const cityName = citySelect.options[citySelect.selectedIndex]?.getAttribute('data-name') || citySelect.value;
            const weightKg = Math.max(1, Math.ceil(checkoutItems.reduce((sum, item) => sum + item.qty, 0) * 0.4));

            document.getElementById('courierLoading').style.display = 'block';
            document.getElementById('courierOptionsContainer').style.display = 'none';

            fetch("{{ route('checkout.shipping') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    provinsi: provName,
                    kota: cityName,
                    weight_kg: weightKg
                })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('courierLoading').style.display = 'none';
                document.getElementById('courierOptionsContainer').style.display = 'block';

                if (data.success && data.couriers) {
                    renderCouriers(data.couriers);
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('courierLoading').style.display = 'none';
                document.getElementById('courierOptionsContainer').style.display = 'block';
                renderCouriers([
                    {
                        code: 'JNE',
                        name: 'JNE Express',
                        services: [
                            { service: 'JNE REG (Reguler)', cost: 12000, etd: '1-3 Hari' }
                        ]
                    }
                ]);
            });
        }

        let allAvailableServices = [];

        function renderCouriers(couriers) {
            allAvailableServices = [];
            couriers.forEach(courier => {
                if (courier.services && Array.isArray(courier.services)) {
                    courier.services.forEach(srv => {
                        allAvailableServices.push({
                            code: courier.code,
                            name: courier.name || courier.code,
                            service: srv.service,
                            cost: srv.cost,
                            etd: srv.etd
                        });
                    });
                }
            });

            populateCourierSelect(allAvailableServices);
        }

        function populateCourierSelect(servicesList) {
            const select = document.getElementById('courierSelect');
            if (!select) return;

            select.innerHTML = '';

            if (!servicesList || servicesList.length === 0) {
                const emptyOpt = document.createElement('option');
                emptyOpt.value = '';
                emptyOpt.textContent = '-- Kurir tidak tersedia --';
                select.appendChild(emptyOpt);
                return;
            }

            const groups = {};
            servicesList.forEach(item => {
                const grpKey = item.name || item.code;
                if (!groups[grpKey]) groups[grpKey] = [];
                groups[grpKey].push(item);
            });

            Object.keys(groups).forEach(grpKey => {
                const optgroup = document.createElement('optgroup');
                optgroup.label = grpKey;

                groups[grpKey].forEach(item => {
                    const opt = document.createElement('option');
                    const globalIdx = allAvailableServices.indexOf(item);
                    opt.value = globalIdx;
                    opt.textContent = `${item.service} — Rp ${formatNumber(item.cost)} (Est. ${item.etd})`;
                    optgroup.appendChild(opt);
                });

                select.appendChild(optgroup);
            });

            // Keep selected or pick first
            let targetGlobalIdx = -1;
            if (selectedCourier) {
                const found = servicesList.find(s => s.code === selectedCourier.code && s.service === selectedCourier.service);
                if (found) {
                    targetGlobalIdx = allAvailableServices.indexOf(found);
                }
            }

            if (targetGlobalIdx >= 0) {
                select.value = targetGlobalIdx;
                onCourierSelectChange(targetGlobalIdx);
            } else if (servicesList.length > 0) {
                const firstGlobalIdx = allAvailableServices.indexOf(servicesList[0]);
                select.value = firstGlobalIdx;
                onCourierSelectChange(firstGlobalIdx);
            }
        }

        function onCourierSelectChange(globalIndex) {
            const idx = parseInt(globalIndex);
            if (isNaN(idx) || !allAvailableServices[idx]) return;

            selectedCourier = allAvailableServices[idx];

            const previewEl = document.getElementById('selectedCourierPreview');
            if (previewEl) {
                previewEl.style.display = 'flex';
            }

            const codeEl = document.getElementById('previewCourierCode');
            if (codeEl) {
                codeEl.textContent = selectedCourier.code;
                const c = (selectedCourier.code || '').toUpperCase();
                if (c === 'JNE') {
                    codeEl.className = 'badge px-3 py-2 fw-bold fs-6 bg-primary text-white';
                } else if (c.includes('J&T') || c.includes('JNT')) {
                    codeEl.className = 'badge px-3 py-2 fw-bold fs-6 bg-danger text-white';
                } else if (c.includes('SICEPAT')) {
                    codeEl.className = 'badge px-3 py-2 fw-bold fs-6 bg-warning text-dark';
                } else if (c.includes('POS')) {
                    codeEl.className = 'badge px-3 py-2 fw-bold fs-6 bg-secondary text-white';
                } else {
                    codeEl.className = 'badge px-3 py-2 fw-bold fs-6 bg-success text-white';
                }
            }

            const serviceEl = document.getElementById('previewCourierService');
            if (serviceEl) serviceEl.textContent = selectedCourier.service;

            const etdEl = document.getElementById('previewCourierEtd');
            if (etdEl) etdEl.innerHTML = `<i class="fa-solid fa-clock me-1 text-success"></i> Estimasi tiba: ${selectedCourier.etd}`;

            const costEl = document.getElementById('previewCourierCost');
            if (costEl) costEl.textContent = `Rp ${formatNumber(selectedCourier.cost)}`;

            updateCalculations();
        }

        const paymentDetails = {
            'transfer_bca': {
                icon: '<i class="fa-solid fa-building-columns text-primary"></i>',
                title: 'Transfer Bank BCA',
                desc: 'Verifikasi transfer manual / otomatis via m-BCA atau ATM BCA'
            },
            'transfer_mandiri': {
                icon: '<i class="fa-solid fa-building-columns text-warning"></i>',
                title: 'Transfer Bank Mandiri',
                desc: 'Bank Mandiri Virtual Account / transfer antar bank'
            },
            'transfer_bri': {
                icon: '<i class="fa-solid fa-building-columns text-info"></i>',
                title: 'Transfer Bank BRI',
                desc: 'Bank BRI / BRIVA transfer via BRImo atau ATM BRI'
            },
            'qris': {
                icon: '<i class="fa-solid fa-qrcode text-danger"></i>',
                title: 'QRIS (Semua E-Wallet)',
                desc: 'Scan kode QR langsung dari GoPay, OVO, Dana, ShopeePay, LinkAja'
            },
            'cod': {
                icon: '<i class="fa-solid fa-hand-holding-dollar text-success"></i>',
                title: 'COD (Bayar di Tempat)',
                desc: 'Bayar tunai ke kurir saat paket pesanan sampai di alamat Anda'
            }
        };

        function onPaymentSelectChange(method) {
            selectedPayment = method;
            const data = paymentDetails[method] || paymentDetails['transfer_bca'];
            const iconEl = document.getElementById('previewPaymentIcon');
            const titleEl = document.getElementById('previewPaymentTitle');
            const descEl = document.getElementById('previewPaymentDesc');

            if (iconEl) iconEl.innerHTML = data.icon;
            if (titleEl) titleEl.textContent = data.title;
            if (descEl) descEl.textContent = data.desc;
        }

        function selectPayment(method) {
            const select = document.getElementById('paymentSelect');
            if (select) select.value = method;
            onPaymentSelectChange(method);
        }

        function updateCalculations() {
            let subtotalProduk = 0;
            let totalDiskon = 0;

            checkoutItems.forEach(item => {
                const itemTotal = item.price * item.qty;
                const diskonNominal = itemTotal * (item.discount / 100);
                subtotalProduk += itemTotal;
                totalDiskon += diskonNominal;
            });

            const dpp = subtotalProduk - totalDiskon;
            const ppn = ppnEnabled ? (dpp * ppnPersen / 100) : 0;
            const ongkir = selectedCourier ? selectedCourier.cost : 0;
            const grandTotal = dpp + ppn + ongkir;

            document.getElementById('summarySubtotal').textContent = `Rp ${formatNumber(subtotalProduk)}`;

            if (totalDiskon > 0) {
                document.getElementById('summaryDiskonRow').style.display = 'flex';
                document.getElementById('summaryDiskon').textContent = `- Rp ${formatNumber(totalDiskon)}`;
            } else {
                document.getElementById('summaryDiskonRow').style.display = 'none';
            }

            if (ppnEnabled && ppn > 0) {
                document.getElementById('summaryPpnRow').style.display = 'flex';
                document.getElementById('summaryPpn').textContent = `Rp ${formatNumber(ppn)}`;
            } else {
                document.getElementById('summaryPpnRow').style.display = 'none';
            }

            document.getElementById('summaryOngkir').textContent = selectedCourier ? `Rp ${formatNumber(ongkir)}` : 'Pilih Kurir';
            document.getElementById('summaryGrandTotal').textContent = `Rp ${formatNumber(grandTotal)}`;
        }

        function processOrder() {
            const name = document.getElementById('recipientName').value.trim();
            const phone = document.getElementById('recipientPhone').value.trim();
            const address = document.getElementById('fullAddress').value.trim();
            
            const provSelect = document.getElementById('provinceSelect');
            const citySelect = document.getElementById('citySelect');
            const districtSelect = document.getElementById('districtSelect');
            const villageSelect = document.getElementById('villageSelect');

            const provName = provSelect.options[provSelect.selectedIndex]?.getAttribute('data-name') || provSelect.value;
            const cityName = citySelect.options[citySelect.selectedIndex]?.getAttribute('data-name') || citySelect.value;
            const kecamatan = districtSelect.options[districtSelect.selectedIndex]?.getAttribute('data-name') || districtSelect.value;
            const kelurahan = villageSelect.options[villageSelect.selectedIndex]?.getAttribute('data-name') || villageSelect.value;
            const postalCode = document.getElementById('postalCode').value.trim();
            const notes = document.getElementById('orderNotes').value.trim();

            if (!name || !phone || !address || !provName || !cityName || !kecamatan || !kelurahan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Lengkapi Alamat',
                    text: 'Mohon isi nama penerima, nomor WhatsApp, provinsi, kota, kecamatan, kelurahan, dan alamat lengkap.',
                    confirmButtonColor: '#9b1b4a'
                });
                return;
            }

            if (!selectedCourier) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Ekspedisi',
                    text: 'Silakan pilih ekspedisi dan layanan kurir pengiriman terlebih dahulu.',
                    confirmButtonColor: '#9b1b4a'
                });
                return;
            }

            const btn = document.getElementById('btnSubmitOrder');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses Pesanan...';

            const payload = {
                nama_penerima: name,
                no_telepon: phone,
                alamat_lengkap: address,
                provinsi: provName,
                kota: cityName,
                kecamatan: kecamatan,
                kelurahan: kelurahan,
                kode_pos: postalCode,
                catatan: notes,
                ekspedisi: selectedCourier.code,
                layanan_ekspedisi: selectedCourier.service,
                ongkir: selectedCourier.cost,
                estimasi_pengiriman: selectedCourier.etd,
                metode_pembayaran: selectedPayment,
                items: checkoutItems.map(i => ({ id: i.id, qty: i.qty }))
            };

            fetch("{{ route('checkout.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Clear cart if direct order was from cart
                    if (!directProduct) {
                        localStorage.removeItem('butik_cart');
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Pesanan Berhasil Dibuat!',
                        text: 'Nomor Pesanan: ' + data.no_pesanan,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-lock me-2"></i> Bayar Sekarang';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Checkout',
                        text: data.message || 'Terjadi kesalahan saat memproses pesanan.',
                        confirmButtonColor: '#9b1b4a'
                    });
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-lock me-2"></i> Bayar Sekarang';
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Koneksi bermasalah atau data tidak valid.',
                    confirmButtonColor: '#9b1b4a'
                });
            });
        }

        function formatNumber(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>

</body>
</html>
