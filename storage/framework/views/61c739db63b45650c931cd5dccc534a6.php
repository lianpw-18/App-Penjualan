

<?php $__env->startSection('content'); ?>
    <style>
        .text-on-left {
            text-align: left !important;
            float: left !important;
            width: 100% !important;
        }
        .loading {
            text-align: center;
            padding: 20px;
        }
        .error-message {
            color: #dc3545;
            text-align: center;
            padding: 20px;
        }
    </style>

    <div class="section-header">
        <h1>Laporan Pembelian Barang (PPN Masukan)</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-danger" id="print-laporan-produk-masuk">
                <i class="fa fa-sharp fa-light fa-print"></i> Print PDF
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-group">
                        <form id="filter_form" action="/laporan-produk-masuk/get-data" method="GET">
                            <div class="row">
                                <div class="col-md-5 my-2">
                                    <label>Pilih Tanggal Mulai :</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                                </div>
                                <div class="col-md-5 my-2">
                                    <label>Pilih Tanggal Selesai :</label>
                                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai">
                                </div>
                                <div class="col-md-2 d-flex align-items-end my-2">
                                    <button type="submit" class="btn btn-primary mx-2">Filter</button>
                                    <button type="button" class="btn btn-danger" id="refresh_btn">Refresh</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Kode Transaksi</th>
                                    <th>Nama Produk</th>
                                    <th>Stok Masuk</th>
                                    <th>Harga Per-Item</th>
                                    <th>Total Harga</th>
                                    <th>Supplier</th>
                                    <th>PPN Masukan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            let table = $('#table_id').DataTable({
                "pageLength": 25,
                "ordering": true,
                "searching": true,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "loadingRecords": "Memuat data...",
                    "processing": "Memproses...",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });

            // Load data pertama kali
            loadData();

            // Handle form submit
            $('#filter_form').submit(function(event) {
                event.preventDefault();
                loadData();
            });

            // Handle refresh button
            $('#refresh_btn').on('click', function() {
                $('#filter_form')[0].reset();
                loadData();
            });

            function loadData() {
                var tanggalMulai = $('#tanggal_mulai').val();
                var tanggalSelesai = $('#tanggal_selesai').val();

                // Show loading
                table.clear().draw();
                $('#table_id tbody').html('<tr><td colspan="9" class="text-center">Memuat data...</td></tr>');

                console.log('Loading data with params:', {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                });

                $.ajax({
                    url: '/laporan-produk-masuk/get-data',
                    type: "GET",
                    dataType: 'JSON',
                    data: {
                        tanggal_mulai: tanggalMulai,
                        tanggal_selesai: tanggalSelesai
                    },
                    success: function(response) {
                        console.log('Response received:', response);
                        
                        let counter = 1;
                        let totalPpnMasukan = 0;
                        
                        // Clear table
                        table.clear();

                        if (!response || response.length === 0) {
                            $('#table_id tbody').html('<tr><td colspan="9" class="text-center">Data tidak ditemukan</td></tr>');
                            $('#table_id tfoot').html('');
                        } else {
                            // Clear tbody untuk menghindari duplikasi
                            $('#table_id tbody').empty();
                            
                            $.each(response, function(key, value) {
                                // Format currency
                                let formattedHargaBeli = parseFloat(value.harga_beli || 0)
                                    .toLocaleString('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    });
                                    
                                let formattedTotalHarga = parseFloat(value.total_harga || 0)
                                    .toLocaleString('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    });

                                // Hitung PPN Masukan (11% dari total harga)
                                let ppnMasukan = (value.total_harga || 0) * 0.11;
                                totalPpnMasukan += ppnMasukan;
                                
                                let formattedPpnMasukan = ppnMasukan.toLocaleString('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                });

                                // Handle supplier name
                                let supplierName = 'Tidak ada supplier';
                                if (value.supplier) {
                                    if (value.supplier.supplier) {
                                        supplierName = value.supplier.supplier;
                                    } else if (value.supplier.nama) {
                                        supplierName = value.supplier.nama;
                                    } else if (value.supplier.name) {
                                        supplierName = value.supplier.name;
                                    }
                                }

                                // Format tanggal
                                let tanggalMasuk = value.tgl_masuk || 'Tidak ada tanggal';

                                // Add row to DataTable
                                table.row.add([
                                    counter++,
                                    tanggalMasuk,
                                    value.kd_transaksi || '-',
                                    value.nm_produk || '-',
                                    value.stok_masuk || 0,
                                    formattedHargaBeli,
                                    formattedTotalHarga,
                                    supplierName,
                                    formattedPpnMasukan
                                ]).draw(false);
                            });

                            // Tambahkan total PPN Masukan di footer
                            let formattedTotalPpn = totalPpnMasukan.toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            });

                            $('#table_id tfoot').html(`
                                <tr>
                                    <th colspan="8" style="text-align:right; font-weight: bold;">Total PPN Masukan:</th>
                                    <th style="font-weight: bold; color: #007bff;">${formattedTotalPpn}</th>
                                </tr>
                            `);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', {
                            status: status,
                            error: error,
                            response: xhr.responseText
                        });
                        
                        $('#table_id tbody').html(`
                            <tr>
                                <td colspan="9" class="text-center error-message">
                                    Terjadi kesalahan saat mengambil data: ${error}
                                    <br><small>Status: ${xhr.status} - ${xhr.statusText}</small>
                                </td>
                            </tr>
                        `);
                        $('#table_id tfoot').html('');
                    }
                });
            }

            // Handle print button
            $('#print-laporan-produk-masuk').on('click', function() {
                var tanggalMulai = $('#tanggal_mulai').val();
                var tanggalSelesai = $('#tanggal_selesai').val();

                var url = '/laporan-produk-masuk/print-produk-masuk';

                let params = [];
                if (tanggalMulai) params.push('tanggal_mulai=' + tanggalMulai);
                if (tanggalSelesai) params.push('tanggal_selesai=' + tanggalSelesai);
                if (params.length > 0) url += '?' + params.join('&');

                window.open(url, '_blank');
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/laporan-produk-masuk/index.blade.php ENDPATH**/ ?>