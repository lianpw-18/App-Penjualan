<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="hover-shadow">
        <td class="text-center">
            <span class="badge badge-secondary"><?php echo e($loop->iteration); ?></span>
        </td>
        <td>
            <span class="badge badge-primary font-weight-bold"><?php echo e($item->kd_pembelian_barang); ?></span>
        </td>
        <td>
            <div class="d-flex align-items-center">
                <i class="fa fa-box text-info mr-2"></i>
                <strong class="text-dark"><?php echo e($item->nm_barang); ?></strong>
            </div>
        </td>
        <td>
            <div class="text-right">
                <span class="text-danger font-weight-bold">
                    <i class="fa fa-money-bill-wave mr-1"></i>
                    Rp. <?php echo e(number_format($item->harga_beli, 0, ',', '.')); ?>

                </span>
            </div>
        </td>
        <td>
            <div class="text-right">
                <span class="text-warning font-weight-bold">
                    <i class="fa fa-percentage mr-1"></i>
                    Rp. <?php echo e(number_format($item->harga_beli * 0.11, 0, ',', '.')); ?>

                </span>
                <small class="d-block text-muted">(11% PPn)</small>
            </div>
        </td>
        <td>
            <div class="text-right">
                <span class="text-success font-weight-bold">
                    <i class="fa fa-calculator mr-1"></i>
                    Rp. <?php echo e(number_format($item->harga_beli + ($item->harga_beli * 0.11), 0, ',', '.')); ?>

                </span>
            </div>
        </td>
        <td class="text-center">
            <?php
                $stokClass = $item->stok > 50 ? 'success' : ($item->stok > 20 ? 'warning' : ($item->stok > 0 ? 'info' : 'danger'));
                $stokIcon = $item->stok > 50 ? 'fa-check-circle' : ($item->stok > 20 ? 'fa-exclamation-triangle' : ($item->stok > 0 ? 'fa-info-circle' : 'fa-times-circle'));
            ?>
            <span class="badge badge-<?php echo e($stokClass); ?> badge-lg">
                <i class="fa <?php echo e($stokIcon); ?> mr-1"></i>
                <?php echo e($item->stok); ?>

            </span>
            <?php if($item->stok <= 10): ?>
                <small class="d-block text-danger mt-1">
                    <i class="fa fa-exclamation-triangle"></i> Stok Rendah
                </small>
            <?php endif; ?>
        </td>
        <td>
            <div class="action-btn-group">
                <!-- Detail Button -->
                <button class="btn-action btn-action-view show-btn" 
                        data-id="<?php echo e($item->id); ?>" 
                        title="Lihat Detail"
                        data-toggle="tooltip"
                        data-placement="top">
                    <i class="fa fa-eye"></i>
                </button>
                
                <!-- Edit Button -->
                <button class="btn-action btn-action-edit edit-btn" 
                        data-id="<?php echo e($item->id); ?>" 
                        title="Edit Barang"
                        data-toggle="tooltip"
                        data-placement="top">
                    <i class="fa fa-edit"></i>
                </button>
                
                <!-- Delete Button -->
                <button class="btn-action btn-action-delete delete-btn" 
                        data-id="<?php echo e($item->id); ?>" 
                        title="Hapus Barang"
                        data-toggle="tooltip"
                        data-placement="top">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .badge-lg {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
    
    .btn-group .btn {
        margin: 0 1px;
    }
    
    .text-right {
        text-align: right !important;
    }
</style>

<script>
    // Initialize tooltips for dynamically loaded content
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });
    });
</script><?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/pembelian-barang/list-produk.blade.php ENDPATH**/ ?>