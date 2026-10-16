<div class="modal fade" id="modal_tambah_pembelian" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="form_tambah_pembelian">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="nm_barang" class="form-control" required>
                    </div>

                    <!-- FIELD YANG HILANG - TAMBAHKAN INI -->
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori_id" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <?php $__currentLoopData = $kategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kategori->id); ?>"><?php echo e($kategori->nama_kategori ?? $kategori->name ?? $kategori->kategori ?? $kategori->nm_kategori); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Satuan</label>
                        <select name="satuan_id" class="form-control" required>
                            <option value="">Pilih Satuan</option>
                            <?php $__currentLoopData = $satuans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $satuan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($satuan->id); ?>"><?php echo e($satuan->nama_satuan ?? $satuan->name ?? $satuan->satuan ?? $satuan->nm_satuan); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <!-- END FIELD YANG HILANG -->

                    <div class="form-group">
                        <label>Harga Beli</label>
                        <input type="number" name="harga_beli" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>

                    <!-- TAMBAHAN KOLOM KENA PPN -->
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="kena_ppn" class="form-check-input" id="kena_ppn" value="1">
                            <label class="form-check-label" for="kena_ppn">Kena PPN</label>
                        </div>
                    </div>
                    <!-- END TAMBAHAN KOLOM KENA PPN -->

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\Users\user\App-Penjualan\resources\views/pembelian-barang/create.blade.php ENDPATH**/ ?>