<?php echo $__env->make('pembelian-barang.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('pembelian-barang.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('pembelian-barang.show', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('pembelian-barang.import', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
    <div class="section-header">
        <h1><i class="fa fa-shopping-cart text-primary"></i> Daftar Pembelian Barang</h1>
        <div class="ml-auto">
            <button class="btn btn-primary" id="tambahBarang">
                <i class="fa fa-plus"></i> Tambah Barang
            </button>
            <button class="btn btn-success" id="importBtn">
                <i class="fa fa-file-excel"></i> Import Data
            </button>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card card-primary shadow-sm">
        <div class="card-header">
            <h4><i class="fa fa-table"></i> Data Pembelian Barang</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_pembelian" class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%"><i class="fa fa-hashtag"></i> No</th>
                            <th><i class="fa fa-barcode"></i> Kode Barang</th>
                            <th><i class="fa fa-box"></i> Nama Barang</th>
                            <th><i class="fa fa-money-bill"></i> Harga Beli</th>
                            <th><i class="fa fa-percentage"></i> Kena PPn</th>
                            <th><i class="fa fa-calculator"></i> Harga Setelah PPn</th>
                            <th><i class="fa fa-cubes"></i> Stok</th>
                            <th width="15%"><i class="fa fa-cogs"></i> Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <?php echo $__env->make('pembelian-barang.import', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with sorting disabled
            let table = $('#table_pembelian').DataTable({
                responsive: true,
                ordering: false, // Disable sorting
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                }
            });

            loadData();

            function loadData() {
                // Show loading
                $('#tbody').html('<tr><td colspan="8" class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');
                
                $.ajax({
                    url: "<?php echo e(route('pembelian-barang.get-data')); ?>",
                    type: "GET",
                    success: function(res) {
                        $('#tbody').html(res.data);
                        // Initialize tooltips after data loaded
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    error: function() {
                        $('#tbody').html('<tr><td colspan="8" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> Gagal memuat data</td></tr>');
                    }
                });
            }

            $('#tambahBarang').click(function() {
                $('#modal_tambah_pembelian').modal('show');
            });

            $('#form_tambah_pembelian').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                // Show loading button
                let submitBtn = $(this).find('button[type="submit"]');
                let originalText = submitBtn.html();
                submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);

                $.ajax({
                    url: "<?php echo e(route('pembelian-barang.store')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $('#modal_tambah_pembelian').modal('hide');
                        loadData();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(err) {
                        showErrors(err.responseJSON);
                    },
                    complete: function() {
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            $('body').on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                
                // Show loading
                Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    url: `/pembelian-barang/${id}/edit`,
                    type: "GET",
                    success: function(res) {
                        Swal.close();
                        if (res.success) {
                            let data = res.data;
                            $('#edit_id').val(data.id);
                            $('#edit_nm_barang').val(data.nm_barang);
                            $('#edit_deskripsi').val(data.deskripsi);
                            $('#edit_harga_beli').val(data.harga_beli);
                            $('#edit_harga_jual').val(data.harga_jual);
                            $('#edit_stok').val(data.stok);
                            $('#modal_edit_pembelian').modal('show');
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire('Error', 'Gagal mengambil data', 'error');
                    }
                });
            });

            $('#form_edit_pembelian').submit(function(e) {
                e.preventDefault();
                let id = $('#edit_id').val();
                let formData = {
                    _token: "<?php echo e(csrf_token()); ?>",
                    _method: 'PUT',
                    nm_barang: $('#edit_nm_barang').val(),
                    deskripsi: $('#edit_deskripsi').val(),
                    harga_beli: $('#edit_harga_beli').val(),
                    harga_jual: $('#edit_harga_jual').val(),
                    stok: $('#edit_stok').val(),
                };

                // Show loading button
                let submitBtn = $(this).find('button[type="submit"]');
                let originalText = submitBtn.html();
                submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Mengupdate...').prop('disabled', true);

                $.ajax({
                    url: `/pembelian-barang/${id}`,
                    type: "POST",
                    data: formData,
                    success: function(res) {
                        $('#modal_edit_pembelian').modal('hide');
                        loadData();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(err) {
                        showErrors(err.responseJSON.errors);
                    },
                    complete: function() {
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            $('body').on('click', '.delete-btn', function() {
                let id = $(this).data('id');
                let namaBarang = $(this).closest('tr').find('td:eq(2)').text();
                
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    html: `Data <strong>${namaBarang}</strong> akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '<i class="fa fa-trash"></i> Ya, hapus!',
                    cancelButtonText: '<i class="fa fa-times"></i> Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/pembelian-barang/${id}`,
                            type: "DELETE",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>"
                            },
                            success: function(res) {
                                loadData();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function() {
                                Swal.fire('Error', 'Gagal menghapus data', 'error');
                            }
                        });
                    }
                });
            });

            $('body').on('click', '.show-btn', function() {
                let id = $(this).data('id');
                
                // Show loading
                Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    url: `/pembelian-barang/${id}`,
                    type: "GET",
                    success: function(res) {
                        Swal.close();
                        
                        // Fill modal with data
                        $('#detail_kd_barang').text(res.barang.kd_pembelian_barang || '-');
                        $('#detail_nm_barang').text(res.barang.nm_barang || '-');
                        $('#detail_deskripsi').text(res.barang.deskripsi || '-');
                        $('#detail_kategori').text(res.barang.kategori ? res.barang.kategori.nama : '-');
                        $('#detail_satuan').text(res.barang.satuan ? res.barang.satuan.nama : '-');
                        $('#detail_harga_beli').text('Rp. ' + numberFormat(res.barang.harga_beli || 0));
                        $('#detail_harga_jual').text('Rp. ' + numberFormat(res.barang.harga_jual || 0));
                        $('#detail_stok').text(res.barang.stok || 0);
                        
                        $('#modal_detail_pembelian').modal('show');
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire('Error', 'Gagal mengambil data detail', 'error');
                    }
                });
            });

            $('#importBtn').click(function() {
                $('#importModal').modal('show');
            });

            function showErrors(errors) {
                $('.alert-danger').remove();
                $.each(errors, function(key, val) {
                    $(`[name="${key}"]`).after(`<div class="alert alert-danger mt-1">${val[0]}</div>`);
                });
            }

            // Function helper untuk format number
            function numberFormat(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/pembelian-barang/index.blade.php ENDPATH**/ ?>