

<?php $__env->startSection('content'); ?>

<style>
    .text-on-left {
        text-align: left !important;
        float: left !important;
        width: 100% !important;
    }
</style>

<div class="section-header">
    <h1>Laporan Penjualan Barang (PPn Keluaran)</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-danger" id="print-laporan-produk-keluar"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    <form id="filter_form" action="/laporan-produk-keluar/get-data" method="GET">
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
                                <th>Tanggal Keluar</th>
                                <th>Kode Transaksi</th>
                                <th>Nama Produk</th>
                                <th>Stok Keluar</th>
                                <th>Harga Per-tem</th>
                                <th>PPN (11%)</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- Tambahkan di sini -->
                    <div class="mt-3">
                        <h5>Total PPN: <span id="total-ppn">Rp0</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Datatables Jquery -->
<script>
    $(document).ready(function () {
        let table = $('#table_id').DataTable();

        loadData();

        $('#filter_form').submit(function (event) {
            event.preventDefault();
            loadData();
        });

        $('#refresh_btn').on('click', function () { 
            refreshTable();
        });

        function loadData() {
            var tanggalMulai    = $('#tanggal_mulai').val();
            var tanggalSelesai  = $('#tanggal_selesai').val();

            $.ajax({
                url: '/laporan-produk-keluar/get-data',
                type: "GET",
                dataType: 'JSON',
                data: {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                },
                success: function (response) {
                    let counter = 1;
                    table.clear().draw();

                    // Hapus tfoot lama jika ada
                    $('#table_id tfoot').remove();

                    if(response.length === 0){
                        $('#table_id tbody');
                    } else {
                        $.each(response, function (key, value) {
                            let ppn = value.harga_beli * 0.11;
                            let formattedHargaBeli  = parseFloat(value.harga_beli).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                            let formattedPPN = parseFloat(ppn).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                            let produkKeluar = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>
                                    <td>${value.tgl_keluar}</td>
                                    <td>${value.kd_transaksi}</td>
                                    <td>${value.nm_produk}</td>
                                    <td>${value.stok_keluar}</td>
                                    <td>${formattedHargaBeli}</td>
                                    <td class="ppn-cell">${ppn}</td>
                                    <td>${value.deskripsi}</td>
                                </tr>
                            `;
                            table.row.add($(produkKeluar)).draw(false);
                        });
                    }
                    updateTotalPPN();
                }
            });
        }

        // Fungsi untuk update total PPN sesuai data yang tampil di tabel (termasuk filter/search)
        function updateTotalPPN() {
            let totalPPN = 0;
            // Ambil data hanya yang sedang tampil (search, sort, paging)
            table.rows({ search: 'applied' }).every(function(){
                let row = this.node();
                // Ambil nilai PPN dari kolom ke-7 (index 6)
                let ppn = parseFloat($(row).find('td.ppn-cell').text());
                if(!isNaN(ppn)) totalPPN += ppn;
            });

            // Update tfoot
            $('#table_id tfoot').remove();
            $('#table_id').append(`
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align:right">Total PPN Keluaran:</th>
                        <th colspan="2">${totalPPN.toLocaleString('id-ID', {style:'currency', currency:'IDR'})}</th>
                    </tr>
                </tfoot>
            `);

            // Update juga di atas tabel
            $('#total-ppn').text(totalPPN.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
        }

        // Update total PPN setiap kali tabel di-draw (search, sort, paging)
        $('#table_id').on('draw.dt', function () {
            updateTotalPPN();
        });

        function refreshTable(){
            $('#filter_form')[0].reset();
            loadData();
        }

        $('#print-laporan-produk-keluar').on('click', function(){
            var tanggalMulai    = $('#tanggal_mulai').val();
            var tanggalSelesai  = $('#tanggal_selesai').val();

            var url = '/laporan-produk-keluar/print-produk-keluar';

            if(tanggalMulai && tanggalSelesai){
                url += '?tanggal_mulai=' + tanggalMulai + '&tanggal_selesai=' + tanggalSelesai;
            }

            window.location.href = url;
        });
    });
</script>





<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/laporan-produk-keluar/index.blade.php ENDPATH**/ ?>