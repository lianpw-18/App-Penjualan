<?php $no = 1; ?>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td class="text-center font-weight-bold text-muted"><?php echo e($no++); ?></td>
        <td>
            <span class="badge badge-primary">
                <i class="fas fa-barcode mr-1" style="font-size: 0.7rem;"></i><?php echo e($item->kd_penjualan_barang); ?>

            </span>
        </td>
        <td>
            <div class="font-weight-bold text-dark"><?php echo e($item->nm_barang); ?></div>
            <?php if($item->kategori): ?>
                <small class="text-muted"><?php echo e($item->kategori->kategori ?? $item->kategori->nm_kategori ?? ''); ?></small>
            <?php endif; ?>
        </td>
        <td>
            <span class="text-muted font-weight-bold" style="font-size: 0.86rem;">
                Rp <?php echo e(number_format($item->harga_beli, 0, ',', '.')); ?>

            </span>
        </td>
        <td>
            <span class="text-success font-weight-bold" style="font-size: 0.92rem;">
                Rp <?php echo e(number_format($item->harga_jual, 0, ',', '.')); ?>

            </span>
        </td>
        <td class="text-center">
            <span class="badge badge-<?php echo e($item->stok > 10 ? 'success' : ($item->stok > 0 ? 'warning' : 'danger')); ?>">
                <i class="fas fa-circle mr-1" style="font-size: 0.4rem;"></i><?php echo e($item->stok); ?>

            </span>
        </td>
        <td class="text-center">
            <?php if($item->diskon_persen > 0): ?>
                <span class="badge badge-info"><?php echo e(rtrim(rtrim(number_format($item->diskon_persen, 2), '0'), '.')); ?>%</span>
            <?php else: ?>
                <span class="text-muted" style="font-size: 0.85rem;">-</span>
            <?php endif; ?>
        </td>
        <td class="text-center">
            <span class="badge badge-warning"><?php echo e(rtrim(rtrim(number_format($item->ppn_persen, 2), '0'), '.')); ?>%</span>
        </td>
        <td class="text-center">
            <div class="action-btn-group justify-content-center">
                <!-- Edit Button -->
                <button class="btn-action btn-action-edit edit-btn" 
                        data-id="<?php echo e($item->id); ?>"
                        data-nm_barang="<?php echo e($item->nm_barang); ?>"
                        data-deskripsi="<?php echo e($item->deskripsi); ?>"
                        data-kategori_id="<?php echo e($item->kategori_id); ?>"
                        data-satuan_id="<?php echo e($item->satuan_id); ?>"
                        data-harga_jual="<?php echo e($item->harga_jual); ?>"
                        data-harga_beli="<?php echo e($item->harga_beli); ?>"
                        data-stok="<?php echo e($item->stok); ?>"
                        data-diskon_persen="<?php echo e($item->diskon_persen); ?>"
                        data-ppn_persen="<?php echo e($item->ppn_persen); ?>"
                        title="Edit Produk"
                        data-toggle="tooltip">
                    <i class="fa fa-pen"></i>
                </button>
                <!-- Detail Button -->
                <button class="btn-action btn-action-view detail-btn" 
                        data-id="<?php echo e($item->id); ?>" 
                        title="Lihat Detail"
                        data-toggle="tooltip">
                    <i class="fa fa-eye"></i>
                </button>
                <!-- Delete Button -->
                <button class="btn-action btn-action-delete delete-btn" 
                        data-id="<?php echo e($item->id); ?>" 
                        title="Hapus Produk"
                        data-toggle="tooltip">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<script>
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script><?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/penjualan-barang/list-produk.blade.php ENDPATH**/ ?>