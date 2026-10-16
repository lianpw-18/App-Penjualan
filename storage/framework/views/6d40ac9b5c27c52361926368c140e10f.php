<div class="modal fade" tabindex="-1" role="dialog" id="importModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Produk Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?php echo e(route('pembelian-barang.import')); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="file">Pilih file Excel</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx, .xls">
                        <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Import</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<?php /**PATH C:\Users\user\App-Penjualan\resources\views/pembelian-barang/import.blade.php ENDPATH**/ ?>