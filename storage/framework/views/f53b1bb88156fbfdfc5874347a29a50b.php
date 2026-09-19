<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas POS & Kasir - Sansin Indonesia</title>
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
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
        
        .particle:nth-child(1) { width: 100px; height: 100px; top: 20%; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 150px; height: 150px; top: 60%; left: 80%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 80px; height: 80px; top: 40%; left: 40%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 120px; height: 120px; top: 70%; left: 30%; animation-delay: 6s; }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
            100% { transform: translateY(0) rotate(360deg); }
        }
        
        .container {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            width: 850px;
            max-width: 100%;
            min-height: 520px;
            display: flex;
            z-index: 1;
        }
        
        .form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            text-align: center;
        }
        
        .form-container h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }
        
        .form-container p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 18px;
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
            padding: 13px 45px;
            background: linear-gradient(to right, #5f27cd, #833ab4);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 15px;
            width: 100%;
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
        
        .overlay {
            padding: 40px;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .overlay h1 {
            font-size: 30px;
            margin-bottom: 12px;
            font-weight: 700;
        }
        
        .overlay p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
            opacity: 0.9;
        }
        
        .ghost {
            background-color: transparent;
            border: 2px solid #fff;
            border-radius: 8px;
            padding: 10px 26px;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .ghost:hover {
            background-color: rgba(255,255,255,0.15);
            transform: translateY(-2px);
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
        
        @media (max-width: 768px) {
            .container { flex-direction: column; min-height: auto; }
            .overlay-container { display: none; }
            .form-container { padding: 30px; }
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
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            <div style="display: inline-block; background: #f3f0fb; color: #5f27cd; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; margin-bottom: 10px;">
                <i class="fa-solid fa-cash-register me-1"></i> PORTAL KHUSUS KASIR & ADMIN POS
            </div>
            <h1>Masuk Dashboard POS</h1>
            <p>Kelola kasir penjualan, master stok barang, dan pesanan</p>
            
            <input id="adminEmail" type="email" name="email" placeholder="Alamat Email Kasir / Admin" value="admin@gmail.com" required />
            <input id="adminPassword" type="password" name="password" placeholder="Password" value="admin123" required />
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
            <button class="sign-in-btn" type="submit">MASUK KE DASHBOARD POS</button>

            <!-- Kredensial Resmi -->
            <div style="margin-top: 18px; padding: 12px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; text-align: center; font-size: 12px; color: #475569;">
                <div style="margin-bottom: 4px; font-weight: 700; color: #5f27cd;">Kredensial Resmi Admin:</div>
                <div style="font-family: monospace; font-size: 12px;">Email: <strong>admin@gmail.com</strong> | Pass: <strong>admin123</strong></div>
            </div>

            <div style="text-align: center; margin-top: 14px;">
                <a href="<?php echo e(url('/')); ?>" style="color: #64748b; font-size: 13px; text-decoration: none; font-weight: 600;">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Katalog Gamis
                </a>
            </div>
        </form>
    </div>

    <div class="overlay-container">
        <div class="overlay">
            <div style="font-size: 40px; margin-bottom: 10px;"><i class="fa-solid fa-cash-register"></i></div>
            <h1>Point of Sale (POS)</h1>
            <p>Sistem kasir dan manajemen transaksi butik modern terintegrasi.</p>
            <button class="ghost" onclick="location.href='<?php echo e(route('login')); ?>'">LOGIN PELANGGAN</button>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/auth/login-admin.blade.php ENDPATH**/ ?>