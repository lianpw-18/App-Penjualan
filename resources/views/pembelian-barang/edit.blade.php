<div class="modal fade" id="modal_edit_pembelian" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="form_edit_pembelian">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pembelian Barang</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" id="edit_nm_barang" name="nm_barang" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea id="edit_deskripsi" name="deskripsi" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Harga Beli</label>
                        <input type="number" id="edit_harga_beli" name="harga_beli" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" id="edit_stok" name="stok" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </div>
        </form>
    </div>
</div>
