<div class="modal fade" tabindex="-1" role="dialog" id="modal_import">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Produk (Excel)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_import" action="<?php echo e(route('penjualan-barang.import')); ?>" method="POST"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Pilih File Excel (.xlsx / .xls)</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls"
                            required>
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
                </div>

                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" id="startImport">Import</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php /**PATH C:\Users\user\App-Penjualan\resources\views/penjualan-barang/import.blade.php ENDPATH**/ ?>