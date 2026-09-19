<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Gamis & Busana Muslimah Elegan | Butik Syar'i</title>
    <meta name="description" content="Koleksi gamis, abaya, khimar, dan dress muslimah syar'i premium dengan bahan adem, jahitan berkualitas, dan harga terbaik.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary: #5f27cd;
            --primary-hover: #481b9e;
            --primary-light: #f3f0fb;
            --primary-soft: #ede7f6;
            --tokopedia-green: #03ac0e;
            --tokopedia-green-hover: #028e0b;
            --accent: #e65100;
            --dark: #1e1e2d;
            --gray-text: #6c757d;
            --bg-light: #f8fafc;
            --card-radius: 20px;
            --pill-radius: 50px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfd;
            color: #2b2d42;
            overflow-x: hidden;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            padding: 18px 0;
            transition: all 0.3s ease;
        }
        .navbar-brand-logo {
            font-weight: 800;
            font-size: 1.45rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand-logo i {
            font-size: 1.6rem;
            background: linear-gradient(135deg, #6c5ce7, #5f27cd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .nav-link {
            font-weight: 500;
            color: #4a5568 !important;
            padding: 8px 16px !important;
            border-radius: 30px;
            transition: all 0.25s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background-color: var(--primary-light);
        }
        .btn-portal {
            background-color: #f7b731;
            color: #2d3436;
            font-weight: 600;
            border-radius: 30px;
            padding: 9px 22px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(247, 183, 49, 0.3);
        }
        .btn-portal:hover {
            background-color: #e1a32a;
            color: #1e272e;
            transform: translateY(-2px);
        }
        .btn-cart-nav {
            background-color: #fff;
            border: 1px solid #e2e8f0;
            color: #4a5568;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .btn-cart-nav:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary-soft);
        }

        /* Hero Section */
        .hero-section {
            padding: 60px 0 80px 0;
            position: relative;
            background: radial-gradient(circle at 80% 20%, rgba(253, 226, 237, 0.5) 0%, rgba(241, 245, 249, 0.4) 50%, rgba(255, 255, 255, 1) 100%);
        }
        .hero-badge {
            background: linear-gradient(135deg, #fce4ec, #f8bbd0);
            color: var(--primary);
            font-weight: 700;
            font-size: 0.85rem;
            padding: 8px 18px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .hero-title {
            font-weight: 800;
            font-size: 3.2rem;
            line-height: 1.18;
            color: #1e1e2f;
            margin-bottom: 22px;
        }
        .hero-title span {
            color: var(--primary);
            position: relative;
        }
        .hero-title span::after {
            content: '';
            position: absolute;
            bottom: 6px;
            left: 0;
            width: 100%;
            height: 10px;
            background: rgba(95, 39, 205, 0.18);
            border-radius: 6px;
            z-index: -1;
        }
        .hero-subtitle {
            font-size: 1.12rem;
            color: #64748b;
            line-height: 1.65;
            margin-bottom: 35px;
            max-width: 520px;
        }

        /* Search Bar */
        .hero-search-box {
            background: #ffffff;
            padding: 10px 12px;
            border-radius: 60px;
            box-shadow: 0 15px 35px rgba(95, 39, 205, 0.08), 0 5px 15px rgba(0,0,0,0.04);
            border: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            gap: 8px;
            max-width: 560px;
        }
        .hero-search-box input {
            border: none;
            padding: 12px 18px;
            font-size: 0.98rem;
            width: 100%;
            outline: none;
            background: transparent;
        }
        .hero-search-box select {
            border: none;
            background: transparent;
            padding: 10px 14px;
            font-size: 0.92rem;
            font-weight: 600;
            color: #475569;
            outline: none;
            cursor: pointer;
            border-right: 1px solid #e2e8f0;
        }
        .btn-search {
            background: linear-gradient(135deg, #6c5ce7, #5f27cd);
            color: white;
            border: none;
            padding: 14px 26px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            white-space: nowrap;
            box-shadow: 0 4px 15px rgba(95, 39, 205, 0.25);
        }
        .btn-search:hover {
            background: linear-gradient(135deg, #5f27cd, #481b9e);
            color: white;
            box-shadow: 0 6px 18px rgba(95, 39, 205, 0.35);
        }

        /* Quick Pills in Hero */
        .hero-quick-tags {
            margin-top: 22px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .quick-tag-pill {
            background: #ffffff;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.84rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .quick-tag-pill:hover, .quick-tag-pill.active {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        /* Hero Visual Illustration */
        .hero-visual-wrapper {
            position: relative;
            text-align: center;
        }
        .hero-blob {
            position: absolute;
            width: 480px;
            height: 480px;
            background: linear-gradient(135deg, #fce4ec 0%, #e0f2fe 100%);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            animation: blobMorph 10s ease-in-out infinite alternate;
        }
        @keyframes blobMorph {
            0% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
            100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        }
        .hero-image-card {
            position: relative;
            z-index: 2;
            background: #ffffff;
            border-radius: 32px;
            padding: 24px;
            box-shadow: 0 25px 50px -12px rgba(155, 27, 74, 0.15);
            display: inline-block;
            max-width: 420px;
            width: 100%;
        }
        .hero-product-img {
            width: 100%;
            height: 360px;
            object-fit: cover;
            border-radius: 24px;
            background: linear-gradient(135deg, #fce4ec, #e8eaf6);
        }

        /* Floating Badges */
        .floating-badge {
            position: absolute;
            z-index: 3;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            padding: 12px 18px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: floatUpDown 4s ease-in-out infinite alternate;
        }
        .badge-1 {
            top: 25px;
            left: -20px;
        }
        .badge-2 {
            bottom: 30px;
            right: -20px;
            animation-delay: 2s;
        }
        @keyframes floatUpDown {
            0% { transform: translateY(0px); }
            100% { transform: translateY(-10px); }
        }

        /* Categories Section (Pontyato ville style) */
        .categories-section {
            padding: 60px 0 40px 0;
        }
        .category-card {
            background: #ffffff;
            border-radius: 22px;
            padding: 28px 20px;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid #f1f5f9;
            box-shadow: 0 6px 16px rgba(0,0,0,0.03);
            height: 100%;
        }
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 30px rgba(155, 27, 74, 0.08);
        }
        .cat-icon-circle {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 16px;
            transition: all 0.3s;
        }
        .cat-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: #1e293b;
            margin-bottom: 4px;
        }
        .cat-count {
            font-size: 0.82rem;
            color: #94a3b8;
            font-weight: 500;
        }

        /* Category Color Themes (from reference image) */
        .cat-theme-1 { background-color: #e0f7fa; color: #00838f; }
        .cat-theme-2 { background-color: #e1f5fe; color: #0277bd; }
        .cat-theme-3 { background-color: #ede7f6; color: #5e35b1; }
        .cat-theme-4 { background-color: #fff3e0; color: #e65100; }
        .cat-theme-5 { background-color: #fce4ec; color: #c2185b; }

        /* Product Catalog Grid (4-columns) */
        .product-section {
            padding: 60px 0 80px 0;
        }
        .section-header {
            margin-bottom: 40px;
        }
        .section-title {
            font-weight: 800;
            font-size: 2.1rem;
            color: #1e1e2f;
            margin-bottom: 8px;
        }
        .section-subtitle {
            color: #64748b;
            font-size: 1rem;
        }

        .product-card {
            background: #ffffff;
            border-radius: 22px;
            border: 1px solid #edf2f7;
            padding: 16px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 4px 18px rgba(0,0,0,0.03);
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(155, 27, 74, 0.09);
            border-color: #f8bbd0;
        }
        .product-thumb-container {
            position: relative;
            width: 100%;
            height: 220px;
            border-radius: 16px;
            overflow: hidden;
            background: linear-gradient(145deg, #fdf2f6, #f1f5f9);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        .product-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .product-card:hover .product-thumb-img {
            transform: scale(1.06);
        }
        .product-badge-cat {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(155, 27, 74, 0.9);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.72rem;
            padding: 4px 10px;
            border-radius: 12px;
            backdrop-filter: blur(4px);
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .product-badge-disc {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #ef4444;
            color: #ffffff;
            font-weight: 800;
            font-size: 0.75rem;
            padding: 4px 9px;
            border-radius: 12px;
        }
        .product-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: #1e293b;
            margin-bottom: 6px;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.7rem;
        }
        .product-meta {
            font-size: 0.82rem;
            color: #94a3b8;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .rating-stars {
            color: #fbbf24;
            font-size: 0.82rem;
        }
        .product-price-box {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px dashed #e2e8f0;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
        }
        .price-final {
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--primary);
            line-height: 1;
        }
        .price-original {
            font-size: 0.85rem;
            color: #94a3b8;
            text-decoration: line-through;
            margin-bottom: 4px;
        }
        .stock-indicator {
            font-size: 0.78rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 8px;
        }
        .stock-ready { background-color: #dcfce7; color: #166534; }
        .stock-low { background-color: #fef3c7; color: #92400e; }
        .stock-empty { background-color: #fee2e2; color: #991b1b; }

        /* Card Action Buttons */
        .product-card-actions {
            margin-top: 14px;
            display: flex;
            gap: 8px;
        }
        .btn-order-wa {
            flex: 1;
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 9px 12px;
            border-radius: 12px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-order-wa:hover {
            background: linear-gradient(135deg, #1ebe5d, #0b7367);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        }
        .btn-quickview {
            background: #f1f5f9;
            color: #475569;
            border: none;
            border-radius: 12px;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .btn-quickview:hover {
            background: var(--primary-light);
            color: var(--primary);
        }
        .btn-add-cart {
            background: #f8fafc;
            color: var(--primary);
            border: 1px solid #fce4ec;
            border-radius: 12px;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .btn-add-cart:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            transform: scale(1.05);
        }
        .btn-buy-now {
            flex: 1;
            background: linear-gradient(135deg, #03ac0e, #028e0b);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 9px 10px;
            border-radius: 12px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-buy-now:hover {
            background: linear-gradient(135deg, #028e0b, #016b08);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(3, 172, 14, 0.3);
            transform: translateY(-1px);
        }
        .btn-order-wa-sm {
            background: #eefbf3;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .btn-order-wa-sm:hover {
            background: #25D366;
            color: #ffffff;
            border-color: #25D366;
            transform: scale(1.05);
        }

        /* Features / Benefit Section */
        .features-section {
            background: #ffffff;
            padding: 70px 0;
            border-top: 1px solid #edf2f7;
            border-bottom: 1px solid #edf2f7;
        }
        .feature-box {
            padding: 24px;
            border-radius: 20px;
            background: #f8fafc;
            height: 100%;
            transition: all 0.3s;
        }
        .feature-box:hover {
            background: #ffffff;
            box-shadow: 0 12px 24px rgba(0,0,0,0.06);
            transform: translateY(-4px);
        }
        .feature-icon-wrapper {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: var(--primary-light);
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 16px;
        }

        /* Consultation CTA Banner */
        .cta-banner {
            background: linear-gradient(135deg, #5f27cd 0%, #341f97 100%);
            border-radius: 28px;
            padding: 50px 40px;
            color: #ffffff;
            margin: 60px 0 80px 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(95, 39, 205, 0.25);
        }
        .cta-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }

        /* Footer */
        .footer-custom {
            background: #111827;
            color: #94a3b8;
            padding: 70px 0 30px 0;
        }
        .footer-brand {
            color: #ffffff;
            font-weight: 800;
            font-size: 1.4rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            font-size: 0.92rem;
            transition: color 0.2s;
        }
        .footer-links a:hover {
            color: #ffffff;
            padding-left: 4px;
        }

        /* Floating WA Widget */
        .floating-wa-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: #ffffff;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4);
            z-index: 999;
            transition: all 0.3s;
            text-decoration: none;
        }
        .floating-wa-btn:hover {
            transform: scale(1.1);
            color: #ffffff;
        }

        /* Modal Styles */
        .modal-product .modal-content {
            border-radius: 28px;
            border: none;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand navbar-brand-logo" href="<?php echo e(url('/')); ?>">
                <i class="fa-solid fa-gem"></i>
                <span>Sansin <span style="color:#e65100;">Indonesia</span></span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo e(url('/')); ?>"><i class="fa-solid fa-house me-1"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#katalog"><i class="fa-solid fa-tags me-1"></i> Koleksi Gamis</a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isPelanggan()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('customer.pesanan')); ?>"><i class="fa-solid fa-box-archive me-1 text-primary"></i> Status Pesanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('customer.profile')); ?>"><i class="fa-solid fa-user-gear me-1 text-primary"></i> Profil Saya</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#kategori"><i class="fa-solid fa-layer-group me-1"></i> Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#keunggulan"><i class="fa-solid fa-award me-1"></i> Keunggulan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak"><i class="fa-solid fa-headset me-1"></i> Kontak</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <!-- Tombol Keranjang Belanja -->
                    <button type="button" class="btn btn-cart-nav position-relative" onclick="openCartDrawer()" title="Keranjang Belanja">
                        <i class="fa-solid fa-bag-shopping text-dark"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="navCartBadge" style="font-size: 10px; display: none;">
                            0
                        </span>
                    </button>

                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isPelanggan()): ?>
                            <div class="dropdown">
                                <button class="btn btn-portal dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-circle-user"></i> <?php echo e(strtok(auth()->user()->name, " ")); ?>

                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 py-2">
                                    <li class="px-3 py-1 text-muted small border-bottom mb-1">
                                        Masuk sebagai <strong><?php echo e(auth()->user()->email); ?></strong>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2" href="<?php echo e(route('customer.pesanan')); ?>">
                                            <i class="fa-solid fa-box-archive me-2 text-primary"></i> Status Pesanan
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2" href="<?php echo e(route('customer.profile')); ?>">
                                            <i class="fa-solid fa-user-gear me-2 text-primary"></i> Profil Saya
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2" href="javascript:void(0)" onclick="openCartDrawer()">
                                            <i class="fa-solid fa-cart-shopping me-2 text-success"></i> Keranjang Belanja
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar (Logout)
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-portal">
                                <i class="fa-solid fa-cash-register me-1"></i> Dashboard POS
                            </a>
                            <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-danger rounded-pill px-2 py-1 btn-sm fw-bold" title="Keluar">
                                    <i class="fa-solid fa-power-off"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- Tombol Login & Register untuk Pelanggan -->
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold small text-decoration-none">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary rounded-pill px-3 py-2 fw-semibold small text-decoration-none" style="background: linear-gradient(135deg, #6c5ce7, #5f27cd); border: none;">
                            <i class="fa-solid fa-user-plus me-1"></i> Daftar
                        </a>
                        <!-- Tombol Khusus Login Kasir / POS -->
                        <a href="<?php echo e(route('login.admin')); ?>" class="btn btn-portal px-3 py-2 fw-bold small text-decoration-none" title="Portal Login Khusus Kasir & Admin POS">
                            <i class="fa-solid fa-cash-register me-1"></i> Login POS
                        </a>
                    <?php endif; ?>

                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Sansin%20Indonesia,%20saya%20ingin%20konsultasi%20produk%20gamis." target="_blank" class="btn btn-cart-nav" title="Hubungi Kami via WhatsApp">
                        <i class="fa-brands fa-whatsapp fs-5 text-success"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (ClassiAds Inspired Design) -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                
                <!-- Left Column: Headline & Search -->
                <div class="col-lg-6">
                    <div class="hero-badge">
                        <i class="fa-solid fa-sparkles text-warning"></i> Koleksi Eksklusif Muslimah 2026
                    </div>
                    
                    <h1 class="hero-title">
                        Tampil Anggun & Syar'i dengan <span>Koleksi Gamis</span> Terbaik.
                    </h1>
                    
                    <p class="hero-subtitle">
                        Temukan berbagai pilihan Gamis Syar'i, Abaya Saudi, French Khimar, dan Kaftan elegan dengan bahan adem kualitas butik premium.
                    </p>

                    <!-- Hero Search Box -->
                    <form action="<?php echo e(url('/')); ?>#katalog" method="GET" class="hero-search-box">
                        <select name="kategori" id="heroCategorySelect">
                            <option value="all">Semua Kategori</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e($kategoriId == $cat->id ? 'selected' : ''); ?>>
                                    <?php echo e($cat->kategori); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <input type="text" name="q" value="<?php echo e($search); ?>" placeholder="Cari nama gamis, abaya, bahan...">
                        <button type="submit" class="btn-search">
                            <i class="fa-solid fa-magnifying-glass"></i> Cari
                        </button>
                    </form>

                    <!-- Quick Tag Pills -->
                    <div class="hero-quick-tags">
                        <span class="text-muted small fw-bold me-1">Pilihan Populer:</span>
                        <a href="<?php echo e(url('/?kategori=all')); ?>#katalog" class="quick-tag-pill <?php echo e(empty($kategoriId) || $kategoriId == 'all' ? 'active' : ''); ?>">Semua</a>
                        <?php $__currentLoopData = $categories->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(url('/?kategori='.$cat->id)); ?>#katalog" class="quick-tag-pill <?php echo e($kategoriId == $cat->id ? 'active' : ''); ?>">
                                <?php echo e($cat->kategori); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Right Column: Visual Layout with Floating Badges (as in reference image) -->
                <div class="col-lg-6">
                    <div class="hero-visual-wrapper">
                        <div class="hero-blob"></div>

                        <!-- Floating Badge Top Left -->
                        <div class="floating-badge badge-1">
                            <div class="rounded-circle bg-success text-white p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div class="text-start">
                                <div class="fw-bold text-dark" style="font-size: 0.88rem;">100% Bahan Asli</div>
                                <div class="text-muted" style="font-size: 0.75rem;">Ceruty & Katun Toyobo</div>
                            </div>
                        </div>

                        <!-- Main Hero Image Card -->
                        <div class="hero-image-card">
                            <img src="https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=700&q=80" alt="Model Busana Muslimah" class="hero-product-img">
                            <div class="d-flex align-items-center justify-content-between mt-3 px-2">
                                <div class="text-start">
                                    <div class="fw-bold text-dark" style="font-size: 1rem;">Abaya Basic Jetblack</div>
                                    <div class="text-primary fw-bold" style="font-size: 0.92rem;">Ready Stok: <?php echo e($totalStock); ?> Pcs</div>
                                </div>
                                <span class="badge bg-danger rounded-pill px-3 py-2">Diskon s/d 20%</span>
                            </div>
                        </div>

                        <!-- Floating Badge Bottom Right -->
                        <div class="floating-badge badge-2">
                            <div class="rounded-circle bg-warning text-dark p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="text-start">
                                <div class="fw-bold text-dark" style="font-size: 0.88rem;">4.9 / 5.0 Rating</div>
                                <div class="text-muted" style="font-size: 0.75rem;">Ribuan Pelanggan Puas</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Categories Section (Pontyato Ville Style from Image) -->
    <section class="categories-section" id="kategori">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.85rem;">Kategori Pilihan</span>
                <h2 class="section-title mt-1">Eksplorasi Berdasarkan Kategori</h2>
                <p class="section-subtitle">Pilih kategori busana muslimah yang paling cocok untuk acara dan kebutuhan Anda.</p>
            </div>

            <?php
                $catIcons = [
                    'Gamis' => ['icon' => 'fa-solid fa-person-dress', 'theme' => 'cat-theme-1'],
                    'Abaya' => ['icon' => 'fa-solid fa-feather-pointed', 'theme' => 'cat-theme-2'],
                    'Dress' => ['icon' => 'fa-solid fa-wand-magic-sparkles', 'theme' => 'cat-theme-3'],
                    'Khimar' => ['icon' => 'fa-solid fa-hand-holding-heart', 'theme' => 'cat-theme-4'],
                    'Bahan' => ['icon' => 'fa-solid fa-scissors', 'theme' => 'cat-theme-5'],
                ];
            ?>

            <div class="row g-4 justify-content-center">
                <!-- All Products Category Card -->
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="<?php echo e(url('/?kategori=all')); ?>#katalog" class="category-card">
                        <div class="cat-icon-circle cat-theme-1">
                            <i class="fa-solid fa-border-all"></i>
                        </div>
                        <div class="cat-title">Semua</div>
                        <div class="cat-count"><?php echo e($totalProducts); ?> Produk</div>
                    </a>
                </div>

                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $themeClass = 'cat-theme-' . (($idx % 5) + 1);
                        $iconClass = 'fa-solid fa-tag';
                        foreach($catIcons as $key => $val) {
                            if(stripos($cat->kategori, $key) !== false) {
                                $iconClass = $val['icon'];
                                $themeClass = $val['theme'];
                                break;
                            }
                        }
                        $productCount = \App\Models\PenjualanBarang::where('kategori_id', $cat->id)->visible()->count();
                    ?>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="<?php echo e(url('/?kategori='.$cat->id)); ?>#katalog" class="category-card <?php echo e($kategoriId == $cat->id ? 'border-primary' : ''); ?>">
                            <div class="cat-icon-circle <?php echo e($themeClass); ?>">
                                <i class="<?php echo e($iconClass); ?>"></i>
                            </div>
                            <div class="cat-title text-truncate" title="<?php echo e($cat->kategori); ?>"><?php echo e($cat->kategori); ?></div>
                            <div class="cat-count"><?php echo e($productCount); ?> Produk</div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Product Showcase Grid (4 Columns as in Image) -->
    <section class="product-section" id="katalog">
        <div class="container">
            
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between section-header gap-3">
                <div>
                    <span class="text-primary fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.85rem;">Katalog Siap Kirim</span>
                    <h2 class="section-title">Koleksi Busana Muslimah Pilihan</h2>
                    <p class="section-subtitle mb-0">Menampilkan <?php echo e($products->total()); ?> pilihan produk gamis & abaya dengan stok real-time.</p>
                </div>

                <!-- Sorting Dropdown -->
                <form action="<?php echo e(url('/')); ?>#katalog" method="GET" class="d-flex align-items-center gap-2">
                    <?php if($search): ?> <input type="hidden" name="q" value="<?php echo e($search); ?>"> <?php endif; ?>
                    <?php if($kategoriId): ?> <input type="hidden" name="kategori" value="<?php echo e($kategoriId); ?>"> <?php endif; ?>
                    
                    <label class="text-muted small fw-bold text-nowrap">Urutkan:</label>
                    <select name="sort" class="form-select form-select-sm rounded-pill px-3 py-2" onchange="this.form.submit()" style="min-width: 170px;">
                        <option value="latest" <?php echo e($sortBy == 'latest' ? 'selected' : ''); ?>>Terbaru</option>
                        <option value="popular" <?php echo e($sortBy == 'popular' ? 'selected' : ''); ?>>Stok Terbanyak</option>
                        <option value="price_low" <?php echo e($sortBy == 'price_low' ? 'selected' : ''); ?>>Harga Terendah</option>
                        <option value="price_high" <?php echo e($sortBy == 'price_high' ? 'selected' : ''); ?>>Harga Tertinggi</option>
                        <option value="name_asc" <?php echo e($sortBy == 'name_asc' ? 'selected' : ''); ?>>Nama A - Z</option>
                    </select>
                </form>
            </div>

            <!-- Products 4-Column Grid -->
            <div class="row g-4">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $images = [
                            'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=500&q=80',
                            'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?auto=format&fit=crop&w=500&q=80',
                            'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=500&q=80',
                            'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=500&q=80',
                            'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=500&q=80',
                            'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=500&q=80',
                        ];
                        $thumb = $images[$product->id % count($images)];
                        $waText = urlencode("Halo Admin Sansin Indonesia, saya tertarik untuk memesan:\n\n*Nama Produk:* {$product->nm_barang}\n*Kode:* {$product->kd_penjualan_barang}\n*Harga:* {$product->formatted_harga_jual}\n\nApakah stok masih tersedia?");
                    ?>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="product-card">
                            
                            <!-- Thumbnail -->
                            <div class="product-thumb-container">
                                <img src="<?php echo e($thumb); ?>" alt="<?php echo e($product->nm_barang); ?>" class="product-thumb-img" loading="lazy">
                                <span class="product-badge-cat"><?php echo e($product->kategori ? $product->kategori->kategori : 'Busana'); ?></span>
                                <?php if($product->diskon_persen > 0): ?>
                                    <span class="product-badge-disc">-<?php echo e(number_format($product->diskon_persen, 0)); ?>%</span>
                                <?php endif; ?>
                            </div>

                            <!-- Title & Meta -->
                            <h3 class="product-title" title="<?php echo e($product->nm_barang); ?>"><?php echo e($product->nm_barang); ?></h3>
                            
                            <div class="product-meta">
                                <div class="rating-stars">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <span class="text-muted">(<?php echo e(rand(20, 95)); ?>)</span>
                                <span class="mx-1">•</span>
                                <span class="badge bg-light text-secondary border"><?php echo e($product->kd_penjualan_barang); ?></span>
                            </div>

                            <!-- Stock Status -->
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small">Satuan: <strong><?php echo e($product->satuan ? $product->satuan->satuan : 'Pcs'); ?></strong></span>
                                <?php if($product->stok > 10): ?>
                                    <span class="stock-indicator stock-ready"><i class="fa-solid fa-circle-check me-1"></i> Stok: <?php echo e($product->stok); ?></span>
                                <?php elseif($product->stok > 0): ?>
                                    <span class="stock-indicator stock-low"><i class="fa-solid fa-triangle-exclamation me-1"></i> Sisa <?php echo e($product->stok); ?></span>
                                <?php else: ?>
                                    <span class="stock-indicator stock-empty"><i class="fa-solid fa-circle-xmark me-1"></i> Habis</span>
                                <?php endif; ?>
                            </div>

                            <!-- Price Box -->
                            <div class="product-price-box">
                                <div>
                                    <?php if($product->diskon_persen > 0): ?>
                                        <div class="price-original"><?php echo e($product->formatted_harga_jual); ?></div>
                                        <div class="price-final"><?php echo e($product->formatted_harga_setelah_diskon); ?></div>
                                    <?php else: ?>
                                        <div class="price-final"><?php echo e($product->formatted_harga_jual); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Card Action Buttons -->
                            <div class="product-card-actions">
                                <button type="button" class="btn-quickview" onclick="openProductModal(<?php echo e($product->id); ?>)" title="Lihat Detail Produk">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button type="button" class="btn-add-cart" onclick="addToCart(<?php echo e($product->id); ?>, '<?php echo e(addslashes($product->nm_barang)); ?>', <?php echo e($product->harga_jual); ?>, <?php echo e($product->diskon_persen ?? 0); ?>, <?php echo e($product->stok); ?>)" title="Tambah ke Keranjang">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                                <a href="javascript:void(0)" onclick="proceedToCheckout('<?php echo e(route('checkout.index', ['product_id' => $product->id, 'qty' => 1])); ?>')" class="btn-buy-now" title="Beli Langsung Ala Tokopedia">
                                    <i class="fa-solid fa-bolt"></i> Beli
                                </a>
                                <a href="https://wa.me/6281234567890?text=<?php echo e($waText); ?>" target="_blank" class="btn-order-wa-sm" title="Beli via WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center py-5">
                        <div class="py-5">
                            <i class="fa-solid fa-magnifying-glass fs-1 text-muted mb-3"></i>
                            <h4 class="fw-bold">Produk Tidak Ditemukan</h4>
                            <p class="text-muted">Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.</p>
                            <a href="<?php echo e(url('/')); ?>#katalog" class="btn btn-primary rounded-pill px-4">Reset Pencarian</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                <?php echo e($products->links('pagination::bootstrap-5')); ?>

            </div>

        </div>
    </section>

    <!-- Features & Keunggulan Section -->
    <section class="features-section" id="keunggulan">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.85rem;">Kenapa Memilih Kami</span>
                <h2 class="section-title mt-1">Standar Kualitas Butik Muslimah</h2>
                <p class="section-subtitle">Komitmen kami menghadirkan busana muslimah syar'i, nyaman, dan terpercaya.</p>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-gem"></i>
                        </div>
                        <h4 class="fw-bold fs-5 mb-2">Bahan Premium</h4>
                        <p class="text-muted small mb-0">Diproduksi dengan bahan katun toyobo, ceruty babydoll, dan armani silk yang adem dan jatuh anggun.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-vest-patches"></i>
                        </div>
                        <h4 class="fw-bold fs-5 mb-2">Jahitan Standar Butik</h4>
                        <p class="text-muted small mb-0">Finishing tepi rapi, jahitan presisi kuat, dengan pola cutting A-line yang nyaman dan syar'i.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <h4 class="fw-bold fs-5 mb-2">Pengiriman Cepat</h4>
                        <p class="text-muted small mb-0">Pesanan dikemas rapi dan dikirim setiap hari ke seluruh pelosok Indonesia dengan garansi aman.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-comments-dollar"></i>
                        </div>
                        <h4 class="fw-bold fs-5 mb-2">Harga Terbaik & Promo</h4>
                        <p class="text-muted small mb-0">Dapatkan harga promo diskon spesial serta kemudahan order eceran maupun seragam keluarga.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WhatsApp Consultation CTA Banner -->
    <section class="container" id="kontak">
        <div class="cta-banner text-center text-lg-start">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary fw-bold px-3 py-2 rounded-pill mb-3">💬 Layanan Fast Response</span>
                    <h2 class="fw-bold fs-2 mb-3">Butuh Bantuan Memilih Model atau Ukuran Gamis?</h2>
                    <p class="text-white-50 mb-0 fs-6">Tim Fashion Stylist kami siap membantu Anda menemukan gamis dan abaya yang tepat via WhatsApp.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Sansin%20Indonesia,%20saya%20ingin%20konsultasi%20ukuran%20dan%20model%20gamis." target="_blank" class="btn btn-light btn-lg rounded-pill px-4 fw-bold text-dark shadow">
                        <i class="fa-brands fa-whatsapp text-success me-2 fs-5"></i> Konsultasi WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row g-5 mb-5">
                
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <i class="fa-solid fa-gem text-warning"></i>
                        <span>Gamis<span class="text-warning">Butik</span></span>
                    </div>
                    <p class="text-muted small mb-4">
                        Pusat penjualan gamis, abaya syar'i, dress muslimah, dan khimar berkualitas butik dengan harga terjangkau. Melayani grosir dan eceran.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white bg-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="text-white bg-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" class="text-white bg-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="fa-brands fa-facebook-f"></i></a>
                    </div>
                </div>

                <div class="col-6 col-lg-2 footer-links">
                    <h5 class="text-white fw-bold mb-3 fs-6">Navigasi</h5>
                    <a href="<?php echo e(url('/')); ?>">Beranda</a>
                    <a href="#katalog">Koleksi Gamis</a>
                    <a href="#kategori">Kategori</a>
                    <a href="#keunggulan">Keunggulan</a>
                </div>

                <div class="col-6 col-lg-3 footer-links">
                    <h5 class="text-white fw-bold mb-3 fs-6">Kategori Populer</h5>
                    <?php $__currentLoopData = $categories->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(url('/?kategori='.$cat->id)); ?>#katalog"><?php echo e($cat->kategori); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="col-lg-3 footer-links">
                    <h5 class="text-white fw-bold mb-3 fs-6">Portal Internal</h5>
                    <p class="text-muted small mb-3">Akses khusus kasir dan staf untuk manajemen transaksi penjualan.</p>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-sm rounded-pill px-3 py-2 w-100">
                        <i class="fa-solid fa-lock me-1"></i> Login Kasir / Admin
                    </a>
                </div>

            </div>

            <div class="pt-4 border-top border-secondary text-center text-muted small">
                &copy; <?php echo e(date('Y')); ?> Sansin Indonesia - Sistem Kasir & Katalog Busana Muslimah. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Widget Button -->
    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Sansin%20Indonesia,%20saya%20ingin%20tanya%20produk%20gamis." target="_blank" class="floating-wa-btn" title="Hubungi Kami via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- Quick View Product Modal -->
    <div class="modal fade modal-product" id="quickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-4 p-md-5 position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-4 shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5 text-center">
                            <div class="rounded-4 overflow-hidden shadow-sm bg-light">
                                <img id="modalImg" src="https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=600&q=80" alt="Produk Gamis" class="img-fluid w-100" style="height: 340px; object-fit: cover;">
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-primary rounded-pill px-3 py-1" id="modalKategori">Gamis</span>
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1" id="modalKode">GMS-001</span>
                            </div>

                            <h3 class="fw-bold text-dark mb-2" id="modalNama">Nama Gamis</h3>
                            
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="rating-stars">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <span class="text-muted small">5.0 (Ulasan Pelanggan)</span>
                            </div>

                            <!-- Price Display -->
                            <div class="mb-3 p-3 bg-light rounded-3 d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small d-block">Harga Produk:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <h4 class="fw-bold text-primary mb-0" id="modalHargaFinal">Rp 0</h4>
                                        <span class="text-muted text-decoration-line-through small" id="modalHargaOriginal"></span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="text-muted small d-block">Status Stok:</span>
                                    <span class="badge bg-success" id="modalStok">Tersedia</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark mb-1">Deskripsi & Spesifikasi:</h6>
                                <p class="text-muted small mb-0" id="modalDeskripsi">Deskripsi produk...</p>
                            </div>

                            <!-- Quantity & Action -->
                            <div class="mb-3">
                                <label class="small text-muted fw-bold mb-1">Jumlah:</label>
                                <div class="input-group" style="width: 140px;">
                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="adjustQty(-1)">-</button>
                                    <input type="number" id="modalQty" class="form-control form-control-sm text-center fw-bold" value="1" min="1" max="99">
                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="adjustQty(1)">+</button>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                                <button type="button" class="btn btn-success py-2 px-3 rounded-pill fw-bold d-inline-flex align-items-center gap-2" onclick="buyNowFromModal()" style="background-color: var(--tokopedia-green); border: none;">
                                    <i class="fa-solid fa-bolt"></i> Beli Langsung
                                </button>
                                <button type="button" class="btn btn-outline-primary py-2 px-3 rounded-pill fw-bold d-inline-flex align-items-center gap-2" onclick="addCartFromModal()">
                                    <i class="fa-solid fa-cart-plus"></i> + Keranjang
                                </button>
                                <a id="modalWaBtn" href="#" target="_blank" class="btn btn-outline-success py-2 px-3 rounded-pill fw-bold d-inline-flex align-items-center gap-2">
                                    <i class="fa-brands fa-whatsapp fs-5"></i> Beli via WA
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shopping Cart Offcanvas Drawer -->
    <div class="offcanvas offcanvas-end border-0 shadow" tabindex="-1" id="cartDrawer" aria-labelledby="cartDrawerLabel" style="width: 420px; max-width: 100vw;">
        <div class="offcanvas-header border-bottom py-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-bag-shopping fs-4 text-primary"></i>
                <h5 class="offcanvas-title fw-bold" id="cartDrawerLabel">Keranjang Belanja</h5>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <div class="offcanvas-body p-3 d-flex flex-column justify-content-between" style="overflow-y: auto;">
            <div id="cartItemsList">
                <!-- Items populated via JS -->
            </div>

            <div id="cartEmptyMessage" class="text-center py-5 my-auto" style="display: none;">
                <i class="fa-solid fa-cart-arrow-down fs-1 text-muted mb-3 opacity-50"></i>
                <h6 class="fw-bold text-secondary">Keranjang Belanja Anda Kosong</h6>
                <p class="text-muted small mb-4">Pilih koleksi gamis terbaik dan tambahkan ke keranjang Anda.</p>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" data-bs-dismiss="offcanvas">
                    Mulai Belanja
                </button>
            </div>
        </div>

        <div class="offcanvas-footer border-top p-3 bg-white" id="cartFooter">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small">Total Belanja:</span>
                <span class="fw-bold fs-5 text-dark" id="cartSubtotalText">Rp 0</span>
            </div>
            <button type="button" onclick="proceedToCheckout('<?php echo e(route('checkout.index')); ?>')" class="btn btn-success w-100 py-3 fw-bold rounded-pill shadow-sm" style="background-color: var(--tokopedia-green); border: none;">
                <i class="fa-solid fa-bag-shopping me-2"></i> Lanjut ke Checkout (Ala Tokopedia)
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentProduct = null;

        // Shopping Cart System (LocalStorage)
        let cart = JSON.parse(localStorage.getItem('butik_cart') || '[]');

        function saveCart() {
            localStorage.setItem('butik_cart', JSON.stringify(cart));
            updateCartBadge();
            renderCartDrawer();
        }

        function updateCartBadge() {
            const badge = document.getElementById('navCartBadge');
            if (!badge) return;
            const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
            if (totalQty > 0) {
                badge.textContent = totalQty;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }

        function addToCart(id, name, price, discount, stock, qty = 1) {
            qty = parseInt(qty) || 1;
            const existingIndex = cart.findIndex(i => i.id === id);
            if (existingIndex > -1) {
                if (cart[existingIndex].qty + qty > stock) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Stok gamis tidak mencukupi (sisa ' + stock + ')',
                        showConfirmButton: false,
                        timer: 2200
                    });
                    return;
                }
                cart[existingIndex].qty += qty;
            } else {
                if (qty > stock) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Stok gamis tidak mencukupi',
                        showConfirmButton: false,
                        timer: 2200
                    });
                    return;
                }
                cart.push({
                    id: id,
                    name: name,
                    price: parseFloat(price),
                    discount: parseFloat(discount || 0),
                    stock: stock,
                    qty: qty
                });
            }

            saveCart();

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Berhasil dimasukkan ke keranjang!',
                showConfirmButton: false,
                timer: 1800
            });
        }

        function removeFromCart(id) {
            cart = cart.filter(i => i.id !== id);
            saveCart();
        }

        function updateCartQty(id, delta) {
            const item = cart.find(i => i.id === id);
            if (!item) return;
            const newQty = item.qty + delta;
            if (newQty <= 0) {
                removeFromCart(id);
            } else if (newQty > item.stock) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: 'Maksimal stok tersedia ' + item.stock,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                item.qty = newQty;
                saveCart();
            }
        }

        let cartDrawerInstance = null;
        function openCartDrawer() {
            renderCartDrawer();
            if (!cartDrawerInstance) {
                cartDrawerInstance = new bootstrap.Offcanvas(document.getElementById('cartDrawer'));
            }
            cartDrawerInstance.show();
        }

        function renderCartDrawer() {
            const container = document.getElementById('cartItemsList');
            const emptyMsg = document.getElementById('cartEmptyMessage');
            const footer = document.getElementById('cartFooter');
            const subtotalText = document.getElementById('cartSubtotalText');

            if (!container) return;

            if (cart.length === 0) {
                container.innerHTML = '';
                emptyMsg.style.display = 'block';
                footer.style.display = 'none';
                return;
            }

            emptyMsg.style.display = 'none';
            footer.style.display = 'block';

            let subtotal = 0;
            container.innerHTML = '';

            cart.forEach(item => {
                const itemPrice = item.price - (item.price * (item.discount / 100));
                const lineTotal = itemPrice * item.qty;
                subtotal += lineTotal;

                container.innerHTML += `
                    <div class="d-flex align-items-center gap-3 p-2 mb-2 rounded-3 border bg-light position-relative">
                        <div class="rounded-3 bg-white border p-2 text-primary text-center" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-shirt fs-5"></i>
                        </div>
                        <div class="flex-grow-1" style="min-width: 0;">
                            <div class="fw-bold text-dark text-truncate small">${item.name}</div>
                            <div class="text-primary fw-bold small">Rp ${formatNumber(itemPrice)}</div>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-secondary py-0 px-2" onclick="updateCartQty(${item.id}, -1)">-</button>
                                    <span class="btn btn-light py-0 px-2 fw-bold text-dark">${item.qty}</span>
                                    <button class="btn btn-outline-secondary py-0 px-2" onclick="updateCartQty(${item.id}, 1)">+</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-link text-danger p-1" onclick="removeFromCart(${item.id})" title="Hapus">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                `;
            });

            subtotalText.textContent = 'Rp ' + formatNumber(subtotal);
        }

        const IS_AUTHENTICATED = <?php echo e(auth()->check() ? 'true' : 'false'); ?>;
        const LOGIN_PAGE_URL = "<?php echo e(route('login')); ?>";

        function proceedToCheckout(targetUrl) {
            targetUrl = targetUrl || "<?php echo e(route('checkout.index')); ?>";
            
            if (!IS_AUTHENTICATED) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Silakan Masuk Terlebih Dahulu',
                    text: 'Untuk melanjutkan ke proses checkout dan pengiriman, silakan masuk ke akun pelanggan atau membuat akun baru.',
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

        function buyNowFromModal() {
            if (!currentProduct) return;
            const qty = parseInt(document.getElementById('modalQty').value) || 1;
            proceedToCheckout(`/checkout?product_id=${currentProduct.id}&qty=${qty}`);
        }

        function addCartFromModal() {
            if (!currentProduct) return;
            const qty = parseInt(document.getElementById('modalQty').value) || 1;
            addToCart(currentProduct.id, currentProduct.nm_barang, currentProduct.harga_jual, currentProduct.diskon_persen, currentProduct.stok, qty);
            const modalEl = document.getElementById('quickViewModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        }

        function openProductModal(productId) {
            fetch(`/katalog/${productId}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(res => {
                if(res.success) {
                    currentProduct = res.data;
                    document.getElementById('modalNama').textContent = currentProduct.nm_barang;
                    document.getElementById('modalKode').textContent = currentProduct.kd_penjualan_barang;
                    document.getElementById('modalKategori').textContent = currentProduct.kategori;
                    document.getElementById('modalDeskripsi').textContent = currentProduct.deskripsi || 'Bahan berkualitas tinggi, adem, dan nyaman dipakai sehari-hari.';
                    document.getElementById('modalStok').textContent = `Tersedia: ${currentProduct.stok} ${currentProduct.satuan}`;
                    
                    if (currentProduct.diskon_persen > 0) {
                        document.getElementById('modalHargaFinal').textContent = currentProduct.formatted_harga_setelah_diskon;
                        document.getElementById('modalHargaOriginal').textContent = currentProduct.formatted_harga_jual;
                        document.getElementById('modalHargaOriginal').style.display = 'inline';
                    } else {
                        document.getElementById('modalHargaFinal').textContent = currentProduct.formatted_harga_jual;
                        document.getElementById('modalHargaOriginal').style.display = 'none';
                    }

                    document.getElementById('modalQty').value = 1;
                    updateModalWaLink();

                    const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
                    modal.show();
                }
            })
            .catch(err => {
                console.error('Error fetching product:', err);
            });
        }

        function adjustQty(change) {
            const qtyInput = document.getElementById('modalQty');
            let val = parseInt(qtyInput.value) || 1;
            val += change;
            if (val < 1) val = 1;
            if (currentProduct && val > currentProduct.stok) val = currentProduct.stok;
            qtyInput.value = val;
            updateModalWaLink();
        }

        function updateModalWaLink() {
            if (!currentProduct) return;
            const qty = document.getElementById('modalQty').value || 1;
            const price = currentProduct.diskon_persen > 0 ? currentProduct.formatted_harga_setelah_diskon : currentProduct.formatted_harga_jual;
            const message = `Halo Admin Sansin Indonesia, saya ingin memesan:\n\n*Produk:* ${currentProduct.nm_barang}\n*Kode:* ${currentProduct.kd_penjualan_barang}\n*Harga Satuan:* ${price}\n*Jumlah:* ${qty} ${currentProduct.satuan}\n\nMohon informasi total pembayaran dan ongkir. Terima kasih.`;
            
            const waUrl = `https://wa.me/6281234567890?text=${encodeURIComponent(message)}`;
            document.getElementById('modalWaBtn').href = waUrl;
        }

        function formatNumber(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        document.getElementById('modalQty').addEventListener('input', updateModalWaLink);

        document.addEventListener('DOMContentLoaded', () => {
            updateCartBadge();
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/landing/index.blade.php ENDPATH**/ ?>