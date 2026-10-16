

<?php $__env->startSection('content'); ?>
    <div class="section-header">
        <h1>Stok Produk</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-danger" id="print-stok-produk"><i
                    class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="opsi-laporan-stok">Filter Stok Berdasarkan :</label>
                                <select class="form-control" name="opsi-laporan-stok" id="opsi-laporan-stok">
                                    <option value="semua" selected>Semua</option>
                                    <option value="minimum">Batas Minimum</option>
                                    <option value="stok-habis">Stok Habis</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis-stok">Jenis Stok :</label>
                                <select class="form-control" name="jenis-stok" id="jenis-stok">
                                    <option value="semua" selected>Semua (Pembelian & Penjualan)</option>
                                    <option value="pembelian">Stok Pembelian</option>
                                    <option value="penjualan">Stok Penjualan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="table-responsive">
                        <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
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

    <!-- Fetch Data  -->
    <script>
        $(document).ready(function() {
            let table = $('#table_id').DataTable();

            loadData('semua', 'semua');

            $('#opsi-laporan-stok, #jenis-stok').on('change', function() {
                var selectedOption = $('#opsi-laporan-stok').val();
                var jenisStok = $('#jenis-stok').val();
                loadData(selectedOption, jenisStok);
            });

            function loadData(selectedOption, jenisStok) {
                $.ajax({
                    url: '/stok-produk/get-data',
                    type: "GET",
                    data: {
                        opsi: selectedOption,
                        jenis_stok: jenisStok
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response, function(key, value) {
                            let jenisClass = value.jenis == 'Pembelian' ? 'badge-info' : 'badge-success';
                            let stokClass = value.stok == 0 ? 'badge-danger' : (value.stok <= 10 ? 'badge-warning' : 'badge-success');
                            
                            let produk = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.kd_barang}</td>
                                    <td>${value.nm_barang}</td>
                                   
                                    <td><span class="badge ${jenisClass}">${value.jenis}</span></td>
                                    <td><span class="badge ${stokClass}">${value.stok}</span></td>
                                    <td>Rp ${formatRupiah(value.harga_beli)}</td>
                                    <td>Rp ${formatRupiah(value.harga_jual)}</td>
                                </tr>
                            `;
                            $('#table_id').DataTable().row.add($(produk)).draw(false);
                        });
                    }
                });
            }

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka);
            }

            $('#print-stok-produk').on('click', function() {
                var selectedOption = $('#opsi-laporan-stok').val();
                var jenisStok = $('#jenis-stok').val();
                window.location.href = '/stok-produk/laporan-stok?opsi=' + selectedOption + '&jenis_stok=' + jenisStok;
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\App-Penjualan\resources\views/stok-produk/index.blade.php ENDPATH**/ ?>