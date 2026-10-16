
<?php $__env->startSection('content'); ?>
<style>
    /* CSS Anda tetap sama */
    .text-on-left {
        text-align: left !important;
        float: left !important;
        width: 100% !important;
    }

    .total-summary {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 15px;
        margin-top: 15px;
    }

    .total-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .total-item:last-child {
        margin-bottom: 0;
        border-top: 1px solid #dee2e6;
        padding-top: 8px;
        font-weight: 600;
        font-size: 1.1em;
    }

    .pph-summary {
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 5px;
        padding: 15px;
        margin-top: 15px;
    }

    .pph-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .pph-item:last-child {
        margin-bottom: 0;
        border-top: 1px solid #ffeaa7;
        padding-top: 8px;
        font-weight: 600;
        font-size: 1.1em;
    }

    .best-seller-summary {
        background-color: #f0f8ff;
        border: 1px solid #b0c4de;
        border-radius: 5px;
        padding: 15px;
        margin-top: 15px;
    }

    .best-seller-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .best-seller-item:last-child {
        margin-bottom: 0;
    }

    .filter-section {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 15px;
    }

    /* Perbaikan untuk Select2 */
    .select2-container {
        width: 100% !important;
    }

    /* Style untuk waktu real time */
    .real-time-clock {
        background-color: #e3f2fd;
        border: 1px solid #90caf9;
        border-radius: 5px;
        padding: 10px;
        text-align: center;
        margin-bottom: 15px;
        font-weight: bold;
        color: #1976d2;
    }
</style>

<!-- Tambahan untuk menampilkan waktu real time -->
<div class="real-time-clock">
    <i class="fa fa-clock"></i> Waktu Saat Ini: <span id="current-time"></span>
</div>

<div class="section-header">
    <h1>Laporan Penjualan</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-danger" id="print-laporan-penjualan"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="filter-section">
                    <form id="filter_form">
                        <div class="row">
                            <div class="col-md-3 my-2">
                                <label>Pilih Tanggal Mulai :</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                            </div>
                            <div class="col-md-3 my-2">
                                <label>Pilih Tanggal Selesai :</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai">
                            </div>
                            <div class="col-md-4 my-2">
                                <label>Filter Produk:</label>
                                <select class="form-control" name="produk_id" id="produk_filter">
                                    <option value="">Semua Produk</option>
                                    
                                </select>
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
                                <th>Tgl Transaksi</th>
                                <th>Waktu Transaksi</th> <!-- Kolom baru untuk waktu -->
                                <th>Kode Transaksi</th>
                                <th>Nama Produk</th>
                                <th>QTY</th>
                                <th>Total Diskon</th>
                                <th>Total PPn</th>
                                <th>Uang Masuk</th>
                                <th>Uang Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

                <!-- Summary totals -->
                <div class="total-summary">
                    <h5 class="mb-3">Ringkasan Total</h5>
                    <div class="total-item">
                        <span>Total Uang Masuk:</span>
                        <span id="total-uang-masuk" class="text-success font-weight-bold">Rp 0</span>
                    </div>
                    <div class="total-item">
                        <span>Total Uang Keluar:</span>
                        <span id="total-uang-keluar" class="text-warning font-weight-bold">Rp 0</span>
                    </div>
                    <div class="total-item">
                        <span>Laba Kotor</span>
                        <span id="gross-profit" class="font-weight-bold">Rp 0</span>
                    </div>
                </div>
                <!-- PPh Final UMKM Summary -->
                <div class="pph-summary">
                    <h5 class="mb-3">PPh Final UMKM (0,5% dari Omzet)</h5>
                    <div class="pph-item">
                        <span>Total Omzet (Uang Masuk):</span>
                        <span id="total-omzet" class="font-weight-bold">Rp 0</span>
                    </div>
                    <div class="pph-item">
                        <span>PPh Final UMKM (0,5%):</span>
                        <span id="pph-final-umkm" class="text-warning font-weight-bold">Rp 0</span>
                    </div>
                    <div class="pph-item">
                        <span>Laba Bersih Setelah PPh</span>
                        <span id="net-profit-after-tax" class="font-weight-bold">Rp 0</span>
                    </div>
                </div>

                <!-- Best Seller Products -->
                <div class="best-seller-summary">
                    <h5 class="mb-3">Produk Terlaris</h5>
                    <div id="best-seller-list">
                        <div class="best-seller-item">
                            <span>Memuat data...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Datatables Jquery -->
<script>
    $(document).ready(function() {
        // Fungsi untuk menampilkan waktu real time
        function updateRealTime() {
            const now = new Date();
            const options = {
                timeZone: 'Asia/Jakarta',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            const timeString = now.toLocaleString('id-ID', options);
            $('#current-time').text(timeString);
        }

        // Update waktu setiap detik
        updateRealTime();
        setInterval(updateRealTime, 1000);

        let table = $('#table_id').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": false,
        });

        // PERBAIKAN: Fungsi untuk memuat opsi filter produk yang unik
        function loadProdukFilterOptions(dataArray) {
            let produkSet = new Set(); // Menggunakan Set untuk menghindari duplikasi
            
            if (dataArray && dataArray.length > 0) {
                dataArray.forEach(function(value) {
                    if (value.detail_penjualans && value.detail_penjualans.length > 0) {
                        value.detail_penjualans.forEach(function(detailItem) {
                            let produkNama = detailItem.nm_produk || detailItem.nama_produk;
                            if (produkNama) {
                                produkSet.add(produkNama); // Set otomatis menghindari duplikasi
                            }
                        });
                    }
                });
            }
            
            let currentVal = $('#produk_filter').val();
            let options = '<option value="">Semua Produk</option>';
            
            // Convert Set ke Array dan sort alphabetically
            let uniqueProduks = Array.from(produkSet).sort();
            
            uniqueProduks.forEach(function(namaProduk) {
                options += `<option value="${namaProduk}">${namaProduk}</option>`;
            });
            
            $('#produk_filter').html(options);
            $('#produk_filter').val(currentVal).trigger('change');
            $('#produk_filter').select2({
                placeholder: "Pilih Produk",
                allowClear: true,
                width: '100%'
            });
        }

        // Load data awal
        loadData();

        $('#filter_form').submit(function(event) {
            event.preventDefault();
            loadData();
        });

        $('#refresh_btn').on('click', function() {
            refreshTable();
        });

        function loadData() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalSelesai = $('#tanggal_selesai').val();
            var namaProduk = $('#produk_filter').val(); // UBAH: Sekarang mengambil nama produk

            console.log('Filter parameters:', {
                tanggalMulai: tanggalMulai,
                tanggalSelesai: tanggalSelesai,
                namaProduk: namaProduk
            });

            // Tampilkan loading
            $('#table_id tbody').html('<tr><td colspan="10" class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');
            $('#best-seller-list').html('<div class="best-seller-item"><span>Memuat data...</span></div>');
            updateTotals(0, 0);

            $.ajax({
                url: '/laporan-penjualan/get-data',
                type: "GET",
                dataType: 'json',
                data: {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai,
                    produk_id: namaProduk // Kirim nama produk ke controller
                },
                beforeSend: function() {
                    console.log('Sending request to get data...');
                },
                success: function(response) {
                    console.log('Response received:', response);

                    table.clear().draw();
                    let counter = 1;
                    let totalUangMasuk = 0;
                    let totalUangKeluar = 0;
                    let productSales = {};

                    if (response.error) {
                        $('#table_id tbody').html('<tr><td colspan="10" class="text-center text-danger">Error: ' + response.message + '</td></tr>');
                        $('#best-seller-list').html('<div class="best-seller-item"><span class="text-danger">Error: ' + response.message + '</span></div>');
                        return;
                    }

                    // Ambil data array dari response
                    let dataArray = response;
                    if (response.data && Array.isArray(response.data)) {
                        dataArray = response.data;
                    }

                    // Update filter produk setiap kali data di-load
                    loadProdukFilterOptions(dataArray);

                    if (!dataArray || dataArray.length === 0) {
                        $('#table_id tbody').html('<tr><td colspan="10" class="text-center">Data tidak ditemukan</td></tr>');
                        $('#best-seller-list').html('<div class="best-seller-item"><span>Tidak ada data penjualan</span></div>');
                        updateTotals(0, 0);
                    } else {
                        $.each(dataArray, function(key, value) {
                            let detailItems = '';
                            let totalQty = 0;
                            let hasMatchingProduct = false;

                            if (value.detail_penjualans && value.detail_penjualans.length > 0) {
                                $.each(value.detail_penjualans, function(index, detailItem) {
                                    // PERBAIKAN: Filter berdasarkan nama produk
                                    if (namaProduk && detailItem.nm_produk != namaProduk) {
                                        return; // Skip item yang tidak sesuai filter
                                    }

                                    if (detailItem.nm_produk || detailItem.nama_produk) {
                                        let namaProdukItem = detailItem.nm_produk || detailItem.nama_produk;
                                        detailItems += `${namaProdukItem} (${detailItem.quantity || 0}), `;
                                        totalQty += parseInt(detailItem.quantity || 0);
                                        hasMatchingProduct = true;

                                        if (productSales[namaProdukItem]) {
                                            productSales[namaProdukItem] += parseInt(detailItem.quantity || 0);
                                        } else {
                                            productSales[namaProdukItem] = parseInt(detailItem.quantity || 0);
                                        }
                                    }
                                });
                                detailItems = detailItems.slice(0, -2);
                            }

                            // Jika filter nama produk aktif dan tidak ada detail yang cocok, skip transaksi ini
                            if (namaProduk && !hasMatchingProduct) {
                                return;
                            }

                            if (!detailItems) {
                                detailItems = 'Tidak ada detail produk';
                            }

                            let uangMasuk = parseFloat(value.jumlah_pembayaran || 0);
                            let uangKeluar = parseFloat(value.uang_kembalian || 0);

                            totalUangMasuk += uangMasuk;
                            totalUangKeluar += uangKeluar;

                            let formattedDiskon = formatRupiah(value.total_diskon || 0);
                            let formattedPPN = formatRupiah(value.total_ppn || 0);
                            let formattedUangMasuk = formatRupiah(uangMasuk);
                            let formattedUangKeluar = formatRupiah(uangKeluar);

                            // Format waktu transaksi dari created_at atau updated_at
                            let waktuTransaksi = '-';
                            if (value.created_at) {
                                let dateTime = new Date(value.created_at);
                                waktuTransaksi = dateTime.toLocaleTimeString('id-ID', {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                });
                            }

                            table.row.add([
                                counter++,
                                value.tgl_transaksi || '-',
                                waktuTransaksi, // Kolom waktu transaksi baru
                                value.kd_pembelian || value.kode_transaksi || '-',
                                detailItems,
                                totalQty,
                                formattedDiskon,
                                formattedPPN,
                                formattedUangMasuk,
                                formattedUangKeluar
                            ]).draw(false);
                        });

                        updateTotals(totalUangMasuk, totalUangKeluar);
                        displayBestSellers(productSales);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.error('Status:', status);
                    console.error('Response Text:', xhr.responseText);

                    let errorMessage = 'Terjadi kesalahan saat mengambil data';
                    try {
                        let errorResponse = JSON.parse(xhr.responseText);
                        if (errorResponse.message) {
                            errorMessage = errorResponse.message;
                        }
                    } catch (e) {
                        errorMessage += ': ' + error;
                    }

                    $('#table_id tbody').html('<tr><td colspan="10" class="text-center text-danger">' + errorMessage + '</td></tr>');
                    $('#best-seller-list').html('<div class="best-seller-item"><span class="text-danger">' + errorMessage + '</span></div>');
                    updateTotals(0, 0);
                }
            });
        }

        function displayBestSellers(productSales) {
            let sortedProducts = [];
            for (let product in productSales) {
                sortedProducts.push({
                    name: product,
                    quantity: productSales[product]
                });
            }
            sortedProducts.sort(function(a, b) {
                return b.quantity - a.quantity;
            });

            let bestSellerHtml = '';
            if (sortedProducts.length === 0) {
                bestSellerHtml = '<div class="best-seller-item"><span>Tidak ada data produk terlaris</span></div>';
            } else {
                let topProducts = sortedProducts.slice(0, 5);
                $.each(topProducts, function(index, product) {
                    bestSellerHtml += `
                        <div class="best-seller-item">
                            <span>${index + 1}. ${product.name}</span>
                            <span class="font-weight-bold">${product.quantity} unit</span>
                        </div>
                    `;
                });
            }
            $('#best-seller-list').html(bestSellerHtml);
        }

        function updateTotals(totalUangMasuk, totalUangKeluar) {
            let grossProfit = totalUangMasuk - totalUangKeluar;
            let pphFinalUMKM = totalUangMasuk * 0.005;
            let netProfitAfterTax = grossProfit - pphFinalUMKM;

            $('#total-uang-masuk').text(formatRupiah(totalUangMasuk));
            $('#total-uang-keluar').text(formatRupiah(totalUangKeluar));

            let grossProfitElement = $('#gross-profit');
            grossProfitElement.text(formatRupiah(grossProfit));
            if (grossProfit > 0) {
                grossProfitElement.removeClass('text-danger').addClass('text-success');
            } else if (grossProfit < 0) {
                grossProfitElement.removeClass('text-success').addClass('text-danger');
            } else {
                grossProfitElement.removeClass('text-success text-danger');
            }

            $('#total-omzet').text(formatRupiah(totalUangMasuk));
            $('#pph-final-umkm').text(formatRupiah(pphFinalUMKM));

            let netProfitElement = $('#net-profit-after-tax');
            netProfitElement.text(formatRupiah(netProfitAfterTax));
            if (netProfitAfterTax > 0) {
                netProfitElement.removeClass('text-danger').addClass('text-success');
            } else if (netProfitAfterTax < 0) {
                netProfitElement.removeClass('text-success').addClass('text-danger');
            } else {
                netProfitElement.removeClass('text-success text-danger');
            }
        }

        function refreshTable() {
            $('#filter_form')[0].reset();
            $('#produk_filter').val(null).trigger('change');
            loadData();
        }

        function formatRupiah(amount) {
            if (amount == null || isNaN(amount)) {
                return 'Rp 0';
            }
            return 'Rp ' + parseFloat(amount).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            });
        }

        $('#print-laporan-penjualan').on('click', function() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalSelesai = $('#tanggal_selesai').val();
            var namaProduk = $('#produk_filter').val(); // UBAH: Sekarang mengambil nama produk
            var url = '/laporan-penjualan/print-penjualan';

            var queryParams = [];
            if (tanggalMulai) queryParams.push('tanggal_mulai=' + tanggalMulai);
            if (tanggalSelesai) queryParams.push('tanggal_selesai=' + tanggalSelesai);
            if (namaProduk) queryParams.push('produk_id=' + encodeURIComponent(namaProduk)); // Encode nama produk

            if (queryParams.length > 0) {
                url += '?' + queryParams.join('&');
            }
            window.open(url, '_blank');
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\App-Penjualan\resources\views/laporan-penjualan/index.blade.php ENDPATH**/ ?>