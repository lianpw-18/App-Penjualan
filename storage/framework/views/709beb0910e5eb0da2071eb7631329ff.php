

<?php echo $__env->make('produk-masuk.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .text-on-left {
            text-align: left !important;
            float: left !important;
            width: 100% !important;
        }
    </style>

    <div class="section-header">
        <h1>Daftar Produk Masuk</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary mx-2" id="button_tambah_barangMasuk"><i class="fa fa-plus"></i>
                Tambah Produk Masuk</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php if(session()->has('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <div class="card card-primary">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Nama Produk</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Stok Masuk</th>
                                    <th>Harga Beli</th>
                                    <th>Total Harga</th>
                                    <th>Supplier</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Datatables Jquery -->
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();

            // Load data produk masuk
            loadDataProdukMasuk();

            function loadDataProdukMasuk() {
                $.ajax({
                    url: '/produk-masuk/get-data',
                    type: "GET",
                    dataType: 'JSON',
                    success: function(response) {
                        let counter = 1;
                        let table = $('#table_id').DataTable();
                        table.clear();
                        
                        if (response.data && Array.isArray(response.data)) {
                            $.each(response.data, function(key, value) {
                                let aksiBtn = `
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="${value.id}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                `;
                                
                                let supplierName = value.supplier ? value.supplier.supplier : '-';
                                
                                let produkMasuk = `
                                    <tr class="barang-row" id="index_${value.id}">
                                        <td>${counter++}</td>   
                                        <td>${value.kd_transaksi}</td>
                                        <td>${value.nm_produk}</td>
                                        <td>${value.tgl_masuk}</td>
                                        <td>${value.stok_masuk}</td>
                                        <td>Rp ${Number(value.harga_beli).toLocaleString('id-ID')}</td>
                                        <td>Rp ${Number(value.total_harga).toLocaleString('id-ID')}</td>
                                        <td>${supplierName}</td>
                                        <td>${aksiBtn}</td>
                                    </tr>
                                `;
                                table.row.add($(produkMasuk));
                            });
                        }
                        table.draw();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error loading data:', error);
                    }
                });
            }

            // Delete event
            $('#table_id').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                if(confirm('Yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: `/produk-masuk/${id}`,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            if(res.success) {
                                loadDataProdukMasuk(); // Reload data
                                Swal.fire('Berhasil!', res.message, 'success');
                            }
                        }
                    });
                }
            });
        });
    </script>

    <!-- Generate Tanggal Hari Ini -->
    <script>
        var today = new Date();
        var year = today.getFullYear();
        var month = (today.getMonth() + 1).toString().padStart(2, '0');
        var day = today.getDate().toString().padStart(2, '0');

        var formattedDate = year + '-' + month + '-' + day;
        document.getElementById('tgl_masuk').value = formattedDate;
    </script>

    <!-- Select2 & Autocomplete -->
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.select2').select2();

                // Event ketika pembelian barang dipilih
                $('#pembelian_barang_id').on('change', function() {
                    var pembelianBarangId = $(this).val();
                    
                    if (pembelianBarangId) {
                        $.ajax({
                            url: `/produk-masuk/pembelian-barang/${pembelianBarangId}`,
                            type: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    var data = response.data;
                                    $('#detail_barang').removeClass('d-none');
                                    $('#info_barang').html(`
                                        <strong>Nama:</strong> ${data.nm_barang}<br>
                                        <strong>Deskripsi:</strong> ${data.deskripsi || '-'}<br>
                                        <strong>Stok Tersedia:</strong> ${data.stok}<br>
                                        <strong>Harga Beli:</strong> Rp ${Number(data.harga_beli).toLocaleString('id-ID')}<br>
                                        <strong>Kategori:</strong> ${data.kategori || '-'}<br>
                                        <strong>Satuan:</strong> ${data.satuan || '-'}
                                    `);
                                }
                            }
                        });
                    } else {
                        $('#detail_barang').addClass('d-none');
                    }
                });
            }, 500);
        });
    </script>

    <!-- Show Modal Tambah & function Store Data -->
    <script>
        $('body').on('click', '#button_tambah_barangMasuk', function() {
            $('#modal_tambah_barangMasuk').modal('show');
            clearAlert();
        });

        function clearAlert() {
            $('.alert-danger').addClass('d-none').removeClass('d-block');
        }

        $('#store').click(function(e) {
            e.preventDefault();
            
            // Debug - cek nilai form
            console.log('Form values:', {
                pembelian_barang_id: $('#pembelian_barang_id').val(),
                tgl_masuk: $('#tgl_masuk').val(),
                stok_masuk: $('#stok_masuk').val(),
                supplier_id: $('#supplier_id').val()
            });

            let pembelian_barang_id = $('#pembelian_barang_id').val();
            let tgl_masuk = $('#tgl_masuk').val();
            let stok_masuk = $('#stok_masuk').val();
            let supplier_id = $('#supplier_id').val();
            let token = $("meta[name='csrf-token']").attr("content");

            // Validasi sederhana
            if (!pembelian_barang_id) {
                alert('Pilih pembelian barang terlebih dahulu');
                return;
            }
            if (!tgl_masuk) {
                alert('Pilih tanggal masuk');
                return;
            }
            if (!stok_masuk || stok_masuk <= 0) {
                alert('Masukkan stok masuk yang valid');
                return;
            }
            if (!supplier_id) {
                alert('Pilih supplier');
                return;
            }

            // Disable button saat proses
            $('#store').prop('disabled', true).text('Menyimpan...');

            $.ajax({
                url: '/produk-masuk',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {
                    pembelian_barang_id: pembelian_barang_id,
                    tgl_masuk: tgl_masuk,
                    stok_masuk: stok_masuk,
                    supplier_id: supplier_id,
                    _token: token
                },
                success: function(response) {
                    console.log('Success response:', response);
                    
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: response.message || 'Data berhasil disimpan',
                        showConfirmButton: true,
                        timer: 3000
                    });

                    // Reset form dan tutup modal
                    $('#form_tambah_produk_masuk')[0].reset();
                    $('#detail_barang').addClass('d-none');
                    $('#modal_tambah_barangMasuk').modal('hide');
                    
                    // Reload data table
                    loadDataProdukMasuk();
                },
                error: function(xhr, status, error) {
                    console.log('Error response:', xhr.responseJSON);
                    console.log('Status:', status);
                    console.log('Error:', error);
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Laravel validation errors
                        Object.keys(xhr.responseJSON.errors).forEach(function(key) {
                            if (xhr.responseJSON.errors[key] && xhr.responseJSON.errors[key][0]) {
                                $(`#alert-${key.replace('_', '-')}`).removeClass('d-none').addClass('d-block');
                                $(`#alert-${key.replace('_', '-')}`).html(xhr.responseJSON.errors[key][0]);
                            }
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        alert('Error: ' + xhr.responseJSON.message);
                    } else {
                        alert('Terjadi kesalahan: ' + error);
                    }
                },
                complete: function() {
                    // Re-enable button
                    $('#store').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
                }
            });
        });

        // Reset form saat modal ditutup
        $('#modal_tambah_barangMasuk').on('hidden.bs.modal', function () {
            $('#form_tambah_produk_masuk')[0].reset();
            $('#detail_barang').addClass('d-none');
            clearAlert();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\App-Penjualan\resources\views/produk-masuk/index.blade.php ENDPATH**/ ?>