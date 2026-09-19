<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Aplikasi Penjualan</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { 
            box-sizing: border-box; 
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }
        
        /* Background Animation */
        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .animated-bg::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: pulse 15s infinite linear;
        }
        
        .animated-bg::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(95,39,205,0.05) 0%, rgba(95,39,205,0) 70%);
            animation: pulse 20s infinite linear reverse;
        }
        
        @keyframes pulse {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        
        /* Floating particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(95,39,205,0.2);
            animation: float 15s infinite linear;
        }
        
        .particle:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .particle:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            left: 80%;
            animation-delay: 2s;
        }
        
        .particle:nth-child(3) {
            width: 80px;
            height: 80px;
            top: 40%;
            left: 40%;
            animation-delay: 4s;
        }
        
        .particle:nth-child(4) {
            width: 120px;
            height: 120px;
            top: 70%;
            left: 30%;
            animation-delay: 6s;
        }
        
        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0;
            }
            50% {
                opacity: 0.3;
            }
            100% {
                transform: translate(100px, 100px) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Container styles */
        .container {
            display: flex;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.15),
                        0 10px 10px rgba(0,0,0,0.12);
            overflow: hidden;
            width: 900px;
            max-width: 100%;
            min-height: 500px;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .container:hover {
            transform: translateY(-5px);
        }
        
        .form-container {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }
        
        h1 { 
            font-weight: 700; 
            margin-bottom: 25px;
            color: #333;
            font-size: 28px;
        }
        
        .social-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .social {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px 15px;
            text-decoration: none;
            font-weight: 600;
            color: #555;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .social:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .social i {
            font-size: 18px;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 15px 0;
            color: #777;
        }
        
        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ddd;
        }
        
        .divider span {
            padding: 0 15px;
            font-size: 14px;
        }
        
        input {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: #5f27cd;
            box-shadow: 0 0 0 2px rgba(95, 39, 205, 0.2);
        }
        
        button.sign-in-btn {
            border-radius: 8px;
            border: none;
            padding: 12px 45px;
            background: linear-gradient(to right, #5f27cd, #833ab4);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(95, 39, 205, 0.3);
        }
        
        button.sign-in-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(95, 39, 205, 0.4);
        }
        
        .overlay-container {
            flex: 1;
            background: linear-gradient(135deg, #5f27cd 0%, #833ab4 100%);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .overlay-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
        }
        
        .overlay {
            padding: 50px;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .overlay h1 {
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .overlay p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
            opacity: 0.9;
        }
        
        .ghost {
            background-color: transparent;
            border: 2px solid #fff;
            border-radius: 8px;
            padding: 12px 30px;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255,255,255,0.2);
        }
        
        .ghost:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,255,255,0.3);
        }
        
        .error {
            color: #e74c3c;
            font-size: 13px;
            margin-bottom: 10px;
            text-align: left;
            background-color: rgba(231, 76, 60, 0.1);
            padding: 8px 12px;
            border-radius: 4px;
            border-left: 3px solid #e74c3c;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                min-height: auto;
            }
            
            .overlay-container {
                display: none;
            }
            
            .form-container {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
<div class="animated-bg"></div>
<div class="particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
</div>

<div class="container">
    <div class="form-container">
        <form method="POST" action="<?php echo e(url('/login')); ?>">
            <?php echo csrf_field(); ?>
            <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Masuk Akun Pelanggan</h1>
            <p style="font-size: 13px; color: #64748b; margin-bottom: 18px;">Silakan masuk untuk checkout belanja gamis dan melihat pesanan Anda</p>
            
            <input type="email" name="email" placeholder="Alamat Email" value="<?php echo e(old('email')); ?>" required />
            <input type="password" name="password" placeholder="Password" required />
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <button class="sign-in-btn" type="submit">MASUK KE AKUN</button>

            <!-- Quick Customer Fill & Admin Switch -->
            <div style="margin-top: 18px; padding-top: 15px; border-top: 1px dashed #e2e8f0; text-align: center; font-size: 12px; color: #64748b;">
                <div style="margin-bottom: 8px; font-weight: 600;">Akun Demo Pelanggan:</div>
                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="fillLogin('pelanggan@gmail.com', '1234')" style="background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 20px; padding: 6px 14px; font-size: 12px; font-weight: 600; cursor: pointer;">
                        <i class="fa-solid fa-user"></i> Gunakan Akun Pelanggan (1234)
                    </button>
                </div>
            </div>

            <div style="text-align: center; margin-top: 16px; padding: 10px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                <span style="font-size: 12px; color: #475569;">Petugas Toko / Kasir?</span>
                <a href="<?php echo e(route('login.admin')); ?>" style="color: #b45309; font-size: 12px; text-decoration: none; font-weight: 700; margin-left: 4px;">
                    <i class="fa-solid fa-cash-register me-1"></i> Login Kasir / POS di Sini &rarr;
                </a>
            </div>

            <div style="text-align: center; margin-top: 14px;">
                <a href="<?php echo e(url('/')); ?>" style="color: #64748b; font-size: 13px; text-decoration: none; font-weight: 600;">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Katalog Gamis
                </a>
            </div>
        </form>
    </div>

    <script>
        function fillLogin(email, password) {
            document.querySelector('input[name="email"]').value = email;
            document.querySelector('input[name="password"]').value = password;
        }
    </script>
    <div class="overlay-container">
        <div class="overlay">
            <h1>Sansin Indonesia</h1>
            <p>Selamat datang di platform penjualan terbaik kami. 
               Nikmati pengalaman berbelanja yang mudah dan nyaman.</p>
            <button class="ghost" onclick="location.href='<?php echo e(url('/register')); ?>'">DAFTAR SEKARANG</button>
        </div>
    </div>
</div>
</body>
</html><?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/auth/login.blade.php ENDPATH**/ ?>