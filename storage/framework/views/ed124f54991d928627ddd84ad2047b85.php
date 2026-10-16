<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right ml-auto">
    <?php if(auth()->guard()->check()): ?>
    <li class="dropdown">
      <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-user">
        <img src="<?php echo e(asset('assets/img/avatar/avatar-1.png')); ?>" alt="User Avatar" class="rounded-circle">
        <span class="d-none d-lg-inline-block"><?php echo e(auth()->user()->name); ?></span>
        <?php if(auth()->user()->role): ?>
          <span class="badge badge-light text-primary ml-2 d-none d-xl-inline" style="font-size: 0.65rem; padding: 3px 8px; border-radius: 9999px; text-transform: uppercase; font-weight: 700; background: rgba(255,255,255,0.95); color: #4338ca !important;"><?php echo e(auth()->user()->role->role); ?></span>
        <?php endif; ?>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="px-3 py-2" style="font-size: 0.78rem; color: #64748b;">
          Login sebagai: <strong class="text-dark d-block"><?php echo e(auth()->user()->name); ?></strong>
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger font-weight-bold" href="#" onclick="event.preventDefault(); 
            Swal.fire({
              title: 'Konfirmasi Keluar',
              text: 'Apakah Anda yakin ingin keluar dari sistem?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#4f46e5',
              cancelButtonColor: '#ef4444',
              confirmButtonText: 'Ya, Keluar',
              cancelButtonText: 'Batal'
            }).then((result) => {
              if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
              }
            });">
          <i class="fas fa-sign-out-alt mr-2"></i> <?php echo e(__('Keluar')); ?>

        </a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
          <?php echo csrf_field(); ?>
        </form>
      </div>
    </li>
    <?php else: ?>
    <li class="nav-item">
      <a href="<?php echo e(route('login')); ?>" class="nav-link">Masuk</a>
    </li>
    <?php endif; ?>
  </ul>
</nav><?php /**PATH C:\Users\user\App-Penjualan\resources\views/partials/navbar.blade.php ENDPATH**/ ?>