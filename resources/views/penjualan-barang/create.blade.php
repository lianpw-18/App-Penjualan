<div class="modal fade" id="modal_tambah_produk" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form_tambah_produk" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Penjualan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nm_barang" id="nm_barang" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_id" id="kategori_id" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategories as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori ?? $kategori->name ?? $kategori->kategori ?? $kategori->nm_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Satuan <span class="text-danger">*</span></label>
                                <select name="satuan_id" id="satuan_id" class="form-control" required>
                                    <option value="">Pilih Satuan</option>
                                    @foreach($satuans as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan ?? $satuan->name ?? $satuan->satuan ?? $satuan->nm_satuan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok" id="stok" class="form-control" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Beli <span class="text-danger">*</span></label>
                                <input type="number" name="harga_beli" id="harga_beli" class="form-control" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Jual <span class="text-danger">*</span></label>
                                <input type="number" name="harga_jual" id="harga_jual" class="form-control" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <!-- TAMBAHAN KOLOM DISKON DAN PPN -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Diskon (%) <span class="text-muted">(Opsional)</span></label>
                                <input type="number" name="diskon_persen" id="diskon_persen" class="form-control" min="0" max="100" step="0.01" value="0" placeholder="Contoh: 10 untuk 10%">
                                <small class="form-text text-muted">Masukkan persentase diskon (0-100%)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>PPN (%) <span class="text-muted">(Default 11%)</span></label>
                                <input type="number" name="ppn_persen" id="ppn_persen" class="form-control" min="0" max="100" step="0.01" value="11" placeholder="Default: 11%">
                                <small class="form-text text-muted">PPN otomatis 11%, bisa disesuaikan</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview Perhitungan -->
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="store" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Reset form when modal is closed
        $('#modal_tambah_produk').on('hidden.bs.modal', function() {
            $('#form_tambah_produk')[0].reset();
            $('#ppn_persen').val('11'); // Reset PPN ke default
            updatePreview(); // Reset preview
        });

        // Fungsi untuk update preview perhitungan
        function updatePreview() {
            var hargaJual = parseFloat($('#harga_jual').val()) || 0;
            var diskonPersen = parseFloat($('#diskon_persen').val()) || 0;
            var ppnPersen = parseFloat($('#ppn_persen').val()) || 11;

            // Hitung diskon
            var diskonAmount = hargaJual * (diskonPersen / 100);
            var hargaSetelahDiskon = hargaJual - diskonAmount;

            // Hitung PPN
            var ppnAmount = hargaSetelahDiskon * (ppnPersen / 100);
            var totalAkhir = hargaSetelahDiskon + ppnAmount;

            // Update preview
            $('#preview_harga').text('Rp ' + numberFormat(hargaJual));
            $('#preview_diskon').text('Rp ' + numberFormat(diskonAmount) + ' (' + diskonPersen + '%)');
            $('#preview_after_diskon').text('Rp ' + numberFormat(hargaSetelahDiskon));
            $('#preview_ppn').text('Rp ' + numberFormat(ppnAmount) + ' (' + ppnPersen + '%)');
            $('#preview_total').text('Rp ' + numberFormat(totalAkhir));
        }

        // Fungsi format number
        function numberFormat(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Event listener untuk update preview saat input berubah
        $('#harga_jual, #diskon_persen, #ppn_persen').on('input keyup', function() {
            updatePreview();
        });

        // Set PPN default saat modal dibuka
        $('#modal_tambah_produk').on('shown.bs.modal', function() {
            if ($('#ppn_persen').val() === '') {
                $('#ppn_persen').val('11');
            }
            updatePreview();
        });
    });
</script>