<!-- Modal Detail Produk -->
<div class="modal fade" id="modal_detail_produk" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalDetailLabel">
                    <i class="fas fa-eye mr-2"></i> Detail Penjualan Barang
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="40%" class="font-weight-bold">
                                        <i class="fas fa-barcode text-primary mr-2"></i> Kode Barang
                                    </td>
                                    <td width="60%">: <span id="detail_kd_barang" class="font-weight-bold">-</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-box text-success mr-2"></i> Nama Barang
                                    </td>
                                    <td>: <span id="detail_nm_barang" class="font-weight-bold">-</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-tag text-warning mr-2"></i> Kategori
                                    </td>
                                    <td>: <span id="detail_kategori">-</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-balance-scale text-info mr-2"></i> Satuan
                                    </td>
                                    <td>: <span id="detail_satuan">-</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-cubes text-secondary mr-2"></i> Stok
                                    </td>
                                    <td>: <span id="detail_stok" class="font-weight-bold">-</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="40%" class="font-weight-bold">
                                        <i class="fas fa-shopping-cart text-danger mr-2"></i> Harga Beli
                                    </td>
                                    <td width="60%">: <span id="detail_harga_beli" class="text-danger font-weight-bold">-</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-money-bill-wave text-success mr-2"></i> Harga Jual
                                    </td>
                                    <td>: <span id="detail_harga_jual" class="text-success font-weight-bold">-</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-percentage text-info mr-2"></i> Kena PPN
                                    </td>
                                    <td>: <span id="detail_kena_ppn">-</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-tags text-warning mr-2"></i> Diskon
                                    </td>
                                    <td>: <span id="detail_diskon">-</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-file-alt text-primary mr-2"></i> Deskripsi
                                    </td>
                                    <td>: <span id="detail_deskripsi">-</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>