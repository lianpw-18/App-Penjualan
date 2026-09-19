<div class="modal fade" id="modal_edit_produk" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form_edit_produk" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="edit_id" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Penjualan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nm_barang" id="edit_nm_barang" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_id" id="edit_kategori_id" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategories as $kategori)
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
                                <select name="satuan_id" id="edit_satuan_id" class="form-control" required>
                                    <option value="">Pilih Satuan</option>
                                    @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan ?? $satuan->name ?? $satuan->satuan ?? $satuan->nm_satuan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok" id="edit_stok" class="form-control" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Beli <span class="text-danger">*</span></label>
                                <input type="number" name="harga_beli" id="edit_harga_beli" class="form-control" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Jual <span class="text-danger">*</span></label>
                                <input type="number" name="harga_jual" id="edit_harga_jual" class="form-control" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KENA PPN -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" name="kena_ppn" id="edit_kena_ppn" class="form-check-input" value="1">
                                    <label class="form-check-label" for="edit_kena_ppn">
                                        Kena PPN (11%)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END KOLOM KENA PPN -->

                    <!-- Bagian Diskon -->
                    <hr>
                    <h6 class="mb-3"><i class="fas fa-tags"></i> Pengaturan Diskon (Opsional)</h6>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nilai Diskon (Rp)</label>
                                <input type="number" name="nilai_diskon" id="edit_nilai_diskon" class="form-control" min="0" step="0.01" placeholder="0">
                                <small class="form-text text-muted">Kosongkan jika tidak ada diskon</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="update" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>