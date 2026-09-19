
<?php $__env->startSection('content'); ?>
<style>
    .text-on-left {
        text-align: left !important;
        float: left !important;
        width: 100% !important;
    }

    /* CSS untuk input disabled */
    input:disabled {
        background-color: #f8f9fa;
        color: #495057;
        cursor: not-allowed;
    }

    /* Style untuk input per-item discount dan PPN */
    .item-input {
        width: 70px;
        text-align: center;
        font-size: 12px;
        padding: 2px 5px;
    }

    .table td {
        vertical-align: middle;
    }

    /* Tombol preview struk styling */
    #preview-struk {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        transition: all 0.3s ease;
    }

    #preview-struk:hover {
        background: linear-gradient(45deg, #218838, #1e7e34);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="section-header">
    <h1>Menu Penjualan</h1>
    <div class="ml-auto">
        <button type="button" class="btn btn-danger float-right" id="refresh"><i class="fas fa-redo"></i> Reset Form</button>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="card card-primary">
            <div class="card-header">
                <h6>Pilih barang yang di order</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Silahkan Pilih Barang<span style="color: red">*</span></label>
                    <select class="select2" name="nm_barang[]" id="nm_barang" multiple="multiple" style="width: 100%">
                        <?php $__currentLoopData = $penjualanbarangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penjualanbarang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($penjualanbarang->stok > 0): ?>
                        <option value="<?php echo e($penjualanbarang->nm_barang ?? $penjualanbarang->nama_barang ?? $penjualanbarang->nm_produk ?? $penjualanbarang->nama_produk); ?>"
                            data-harga_jual="<?php echo e($penjualanbarang->harga_jual ?? $penjualanbarang->harga_satuan); ?>"
                            data-stok="<?php echo e($penjualanbarang->stok); ?>"
                            data-diskon="<?php echo e($penjualanbarang->diskon_persen ?? 0); ?>"
                            data-ppn="<?php echo e($penjualanbarang->ppn_persen ?? 11); ?>">
                            <?php echo e($penjualanbarang->nm_produk ?? $penjualanbarang->nama_produk ?? $penjualanbarang->nm_barang ?? $penjualanbarang->nama_barang); ?>

                        </option>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nm_Barang"></div>
                </div>

                <button type="button" class="btn btn-primary float-right" id="store">Lanjutkan</button>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-primary">
            <div class="card-header">
                <h6>Keranjang Pembelian</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-danger alert-dismissible show fade" id="alert-stok" style="display:none">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Stok Melebihi Batas !
                    </div>
                </div>
                <div class="alert alert-primary alert-has-icon">
                    <div class="alert-icon"><i class="fas fa-money-check"></i></div>
                    <div class="alert-body">
                        <div class="alert-title total-harga" id="totalHarga">Rp 0</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Barang Yang Dipilih</th>
                                <th scope="col">Harga</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Diskon (%)</th>
                                <th scope="col">PPN (%)</th>
                                <th scope="col">Total</th>
                                <th scope="col">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="cart">
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="card-body">
                    <div class="alert alert-success alert-dismissible show fade" id="alert-success" style="display:none">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            Pembayaran Sukses
                        </div>
                    </div>
                    <div class="alert alert-warning alert-dismissible show fade" id="alert-warning" style="display:none">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            Jumlah Uang Yang Dimasukkan Kurang
                        </div>
                    </div>
                    <input type="hidden" id="id">
                    <input type="hidden" name="status" id="status" value="lunas">
                    <div class="form-group">
                        <label for="jumlah_pembayaran">Jumlah Pembayaran <span style="color: red">*</span></label>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp</div>
                            <input type="number" class="form-control" id="jumlah_pembayaran" required min="0" step="1">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="uang_kembalian">Kembalian</label>
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp</div>
                                <input type="number" class="form-control" id="uang_kembalian" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Preview Struk dan Proses Pembayaran -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-success" id="preview-struk">
                            <i class="fas fa-eye"></i> Preview Struk
                        </button>
                        <button type="button" class="btn btn-primary" id="proses_pembayaran">Proses Pembayaran</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo $__env->make('menu-penjualan.struk', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Datatables Jquery -->
<script>
    document.getElementById('refresh').addEventListener('click', function() {
        window.location.replace('/menu-penjualan');
    });
</script>
<!-- Datatables Jquery -->
<script>
    $(document).ready(function() {
        $('#table_id').DataTable();
    })
</script>
<!-- Select2 & Autocomplete -->
<script>
    $(document).ready(function() {
        $('.select2').select2();

        // Fungsi untuk format Rupiah tanpa desimal
        function formatRupiah(angka) {
            if (isNaN(angka) || angka === null || angka === undefined) return "Rp 0";
            return "Rp " + parseFloat(angka).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Fungsi untuk format angka tanpa prefix Rp
        function formatAngka(angka) {
            if (isNaN(angka) || angka === null || angka === undefined) return "0";
            return parseFloat(angka).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Fungsi untuk validasi angka
        function isValidNumber(value) {
            return !isNaN(value) && isFinite(value) && value !== null && value !== undefined;
        }

        // Fungsi untuk menghitung total per item (KONSISTEN dengan struk)
        function hitungTotalPerItem(nm_barang, quantity) {
            var option = $(`#nm_barang option[value="${nm_barang}"]`);
            var harga = parseFloat(option.data('harga_jual')) || 0;
            var diskon = parseFloat(option.data('diskon')) || 0;
            var ppn = parseFloat(option.data('ppn')) || 0;

            // Validasi input
            if (!isValidNumber(harga) || !isValidNumber(quantity) || quantity <= 0) {
                return 0;
            }

            var subtotal = harga * quantity;
            var nominalDiskon = (subtotal * diskon) / 100;
            var subtotalSetelahDiskon = subtotal - nominalDiskon;
            var nominalPpn = (subtotalSetelahDiskon * ppn) / 100;
            var totalFinal = subtotalSetelahDiskon + nominalPpn;

            // Pastikan hasil perhitungan valid
            return isValidNumber(totalFinal) ? totalFinal : 0;
        }

        var selectedProducts = [];
        $('#store').on('click', function() {
            var selectedOptions = $('#nm_barang option:selected');
            if (selectedOptions && selectedOptions.length > 0) {
                selectedOptions.each(function(index, option) {
                    var value = $(option).val();
                    if (selectedProducts.indexOf(value) === -1) {
                        selectedProducts.push(value);
                        updateKeranjang();
                    }
                });
            }
        });

        // Menampilkan product yang dipilih kasir pada keranjang
        function updateKeranjang() {
            $('#cart').empty();
            selectedProducts.forEach(function(nm_barang, index) {
                var option = $(`#nm_barang option[value="${nm_barang}"]`);
                var harga = parseFloat(option.data('harga_jual')) || 0;
                var diskon = parseFloat(option.data('diskon')) || 0;
                var ppn = parseFloat(option.data('ppn')) || 0;
                var quantity = 1;
                var totalPerItem = hitungTotalPerItem(nm_barang, quantity);

                $('#cart').append(`
                <tr class="cart-item" data-nm-barang="${nm_barang}">
                    <td>${index + 1}</td>
                    <td>${nm_barang}</td>
                    <td>${formatRupiah(harga)}</td>
                    <td>
                        <button class="btn btn-sm btn-primary pengurangan-quantity">-</button>
                        <span class="quantity">${quantity}</span>
                        <button class="btn btn-sm btn-primary penambahan-quantity">+</button>
                    </td>
                    <td>
                        <input type="text" class="form-control item-input" value="${diskon}%" disabled>
                    </td>
                    <td>
                        <input type="text" class="form-control item-input" value="${ppn}%" disabled>
                    </td>
                    <td class="item-total">${formatRupiah(totalPerItem)}</td>
                    <td><button class="btn btn-sm btn-danger remove-from-cart"><i class="fa fa-regular fa-times"></i></button></td>
                </tr>
            `);
            });
            updateTotalHarga();
        }

        // Hitung semua harga yang ada di keranjang
        function updateTotalHarga() {
            var totalKeseluruhan = 0;
            $('.cart-item').each(function() {
                var nm_barang = $(this).data('nm-barang');
                var quantity = parseInt($(this).find('.quantity').text()) || 0;
                var totalHarga = hitungTotalPerItem(nm_barang, quantity);
                totalKeseluruhan += totalHarga;

                // Update total per item di tampilan
                $(this).find('.item-total').text(formatRupiah(totalHarga));
            });

            $('#totalHarga').text(formatRupiah(totalKeseluruhan));
        }

        // Update kembalian ketika jumlah pembayaran berubah
        $('#jumlah_pembayaran').on('input', function() {
            var jumlahPembayaran = parseFloat($(this).val()) || 0;
            var totalKeseluruhan = 0;

            $('.cart-item').each(function() {
                var nm_barang = $(this).data('nm-barang');
                var quantity = parseInt($(this).find('.quantity').text()) || 0;
                totalKeseluruhan += hitungTotalPerItem(nm_barang, quantity);
            });

            var kembalian = jumlahPembayaran - totalKeseluruhan;
            $('#uang_kembalian').val(isValidNumber(kembalian) && kembalian >= 0 ? kembalian.toFixed(0) : 0);
        });

        // Kurangi Quantity pada keranjang 
        $('#cart').on('click', '.pengurangan-quantity', function() {
            var nm_barang = $(this).closest('.cart-item').data('nm-barang');
            var quantityElement = $(this).siblings('.quantity');
            var quantitySekarang = parseInt(quantityElement.text()) || 1;
            if (quantitySekarang > 1) {
                quantitySekarang--;
                quantityElement.text(quantitySekarang);
                updateTotalHarga();
                // Update kembalian
                $('#jumlah_pembayaran').trigger('input');
            }
        });

        // Tambah Quantity pada keranjang 
        $('#cart').on('click', '.penambahan-quantity', function() {
            var nm_barang = $(this).closest('.cart-item').data('nm-barang');
            var quantityElement = $(this).siblings('.quantity');
            var quantitySekarang = parseInt(quantityElement.text()) || 1;
            var stok = parseInt($(`#nm_barang option[value="${nm_barang}"]`).data('stok')) || 0;
            if (quantitySekarang < stok) {
                quantitySekarang++;
                quantityElement.text(quantitySekarang);
                updateTotalHarga();
                // Update kembalian
                $('#jumlah_pembayaran').trigger('input');
            } else {
                $('#alert-stok').show();
            }
        });

        // Hapus List Barang Dari Keranjang
        $('#cart').on('click', '.remove-from-cart', function() {
            var nm_barang = $(this).closest('.cart-item').data('nm-barang');
            var index = selectedProducts.indexOf(nm_barang);
            if (index !== -1) {
                selectedProducts.splice(index, 1);
                $(this).closest('.cart-item').remove();
                updateKeranjang();
                // Update kembalian
                $('#jumlah_pembayaran').trigger('input');
            }
        });

        // Proses pembayaran Cash
        $('#proses_pembayaran').on('click', function() {
            // Hide previous alerts
            $('#alert-warning').hide();
            $('#alert-success').hide();

            var status = $('#status').val();
            var nm_pelanggan = $('#nm_pelanggan').val();

            // Validasi input pembayaran
            var jumlahPembayaranInput = $('#jumlah_pembayaran').val();
            if (!jumlahPembayaranInput || jumlahPembayaranInput.trim() === '') {
                $('#alert-warning').find('.alert-body').text('Jumlah pembayaran tidak boleh kosong').end().show();
                return;
            }

            var jumlahPembayaran = parseFloat(jumlahPembayaranInput);
            if (!isValidNumber(jumlahPembayaran) || jumlahPembayaran <= 0) {
                $('#alert-warning').find('.alert-body').text('Jumlah pembayaran harus berupa angka yang valid dan lebih dari 0').end().show();
                return;
            }

            // Validasi keranjang tidak kosong
            if ($('.cart-item').length === 0) {
                $('#alert-warning').find('.alert-body').text('Keranjang belanja masih kosong').end().show();
                return;
            }

            var barangData = [];
            var subTotal = 0;
            var hasError = false;

            $('.cart-item').each(function() {
                var nm_barang = $(this).data('nm-barang');
                var option = $(`#nm_barang option[value="${nm_barang}"]`);

                var harga_barang = parseFloat(option.data('harga_jual')) || 0;
                var diskonPresentase = parseFloat(option.data('diskon')) || 0;
                var ppnPresentase = parseFloat(option.data('ppn')) || 0;
                var quantity = parseInt($(this).find('.quantity').text()) || 0;

                // Validasi data item
                if (!isValidNumber(harga_barang) || !isValidNumber(quantity) || quantity <= 0) {
                    console.error('Invalid data for item:', nm_barang);
                    hasError = true;
                    return;
                }

                // Hitung total per item dengan diskon dan PPN masing-masing barang
                var subtotalBarang = harga_barang * quantity;
                var nominalDiskon = (subtotalBarang * diskonPresentase) / 100;
                var subtotalSetelahDiskon = subtotalBarang - nominalDiskon;
                var nominalPpn = (subtotalSetelahDiskon * ppnPresentase) / 100;
                var totalPerItem = subtotalSetelahDiskon + nominalPpn;

                // Validasi hasil perhitungan
                if (!isValidNumber(totalPerItem)) {
                    console.error('Invalid calculation for item:', nm_barang);
                    hasError = true;
                    return;
                }

                subTotal += totalPerItem;

                barangData.push({
                    nm_PenjualanBarang: nm_barang,
                    harga_PenjualanBarang: harga_barang,
                    quantity: quantity,
                    total_harga_PenjualanBarang: subtotalBarang,
                    diskon_persen: diskonPresentase,
                    ppn_persen: ppnPresentase,
                    total_final: totalPerItem
                });
            });

            // Check for errors in calculation
            if (hasError) {
                $('#alert-warning').find('.alert-body').text('Terjadi kesalahan dalam perhitungan. Silakan coba lagi.').end().show();
                return;
            }

            // Validasi subTotal
            if (!isValidNumber(subTotal) || subTotal <= 0) {
                $('#alert-warning').find('.alert-body').text('Terjadi kesalahan dalam perhitungan total').end().show();
                return;
            }

            var uangKembalian = jumlahPembayaran - subTotal;

            // Validasi uangKembalian
            if (!isValidNumber(uangKembalian)) {
                $('#alert-warning').find('.alert-body').text('Terjadi kesalahan dalam perhitungan kembalian').end().show();
                return;
            }

            // Update tampilan kembalian
            $('#uang_kembalian').val(Math.max(0, uangKembalian).toFixed(0));

            if (uangKembalian < 0) {
                $('#alert-warning').find('.alert-body').text('Jumlah uang yang dimasukkan kurang').end().show();
                return;
            }

            // Final validation before sending to server
            if (barangData.length === 0) {
                $('#alert-warning').find('.alert-body').text('Tidak ada barang yang valid untuk diproses').end().show();
                return;
            }

            // Disable button to prevent double submission
            $('#proses_pembayaran').prop('disabled', true).text('Processing...');

            $.ajax({
                url: '/menu-penjualan',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    status: status,
                    nm_pelanggan: nm_pelanggan,
                    jumlah_pembayaran: jumlahPembayaran,
                    diskon: 0, // Set ke 0 karena diskon sudah per item
                    ppn: 0, // Set ke 0 karena PPN sudah per item
                    penjualan_item: barangData,
                    sub_total: subTotal,
                    uang_kembalian: Math.max(0, uangKembalian),
                },
                success: function(response) {
                    // Re-enable button
                    $('#proses_pembayaran').prop('disabled', false).text('Proses Pembayaran');

                    if (response.success) {
                        $('#alert-success').show().delay(3000).fadeOut();
                        var kd_pembelian = response.kd_pembelian;

                        // Prepare data untuk struk (KONSISTEN dengan perhitungan frontend)
                        var strukData = {
                            kd_pembelian: kd_pembelian,
                            items: barangData.map(function(item) {
                                return {
                                    nm_barang: item.nm_PenjualanBarang,
                                    harga_barang: item.harga_PenjualanBarang,
                                    quantity: item.quantity,
                                    diskon_persen: item.diskon_persen,
                                    ppn_persen: item.ppn_persen,
                                    total_final: item.total_final
                                };
                            }),
                            jumlah_pembayaran: jumlahPembayaran,
                            diskon: 0,
                            ppn: 0,
                            uang_kembalian: Math.max(0, uangKembalian)
                        };

                        // Tampilkan struk jika function tersedia
                        if (typeof showStruk === 'function') {
                            showStruk(kd_pembelian, strukData);
                        }

                        // Reset form dan keranjang
                        selectedProducts = [];
                        updateKeranjang();
                        $('#jumlah_pembayaran').val('');
                        $('#uang_kembalian').val('');
                        $('#cart').empty();
                        $('#totalHarga').text('Rp 0');
                        $('#nm_pelanggan').val('');
                        $('#nm_barang').val(null).trigger('change');
                    } else {
                        $('#alert-warning').find('.alert-body').text(response.message || 'Terjadi kesalahan saat menyimpan data.').end().show();
                    }
                },
                error: function(xhr, status, error) {
                    // Re-enable button
                    $('#proses_pembayaran').prop('disabled', false).text('Proses Pembayaran');

                    let msg = 'Terjadi kesalahan saat menyimpan data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    $('#alert-warning').find('.alert-body').text(msg).end().show();
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/menu-penjualan/index.blade.php ENDPATH**/ ?>