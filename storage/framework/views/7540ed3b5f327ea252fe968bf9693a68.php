
<style>
    /* CSS untuk struk */
    .struk-container {
        width: 300px;
        font-family: 'Courier New', monospace;
        font-size: 12px;
        line-height: 1.2;
        margin: 0 auto;
        background: white;
        padding: 10px;
    }

    .struk-header {
        text-align: center;
        border-bottom: 1px dashed #000;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .struk-title {
        font-size: 16px;
        font-weight: bold;
        margin: 5px 0;
    }

    .struk-info {
        font-size: 10px;
        margin: 2px 0;
    }

    .struk-item {
        display: flex;
        justify-content: space-between;
        margin: 3px 0;
        font-size: 11px;
    }

    .struk-item-detail {
        font-size: 10px;
        color: #666;
        margin-left: 10px;
        margin-top: -2px;
    }

    .struk-separator {
        border-top: 1px dashed #000;
        margin: 8px 0;
    }

    .struk-total {
        font-weight: bold;
        font-size: 12px;
    }

    .struk-footer {
        text-align: center;
        margin-top: 10px;
        padding-top: 5px;
        border-top: 1px dashed #000;
        font-size: 10px;
    }

    .modal-struk {
        font-family: 'Courier New', monospace;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .struk-container,
        .struk-container * {
            visibility: visible;
        }

        .struk-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100% !important;
        }

        .modal-backdrop {
            display: none !important;
        }
    }
</style>

<div class="modal fade" id="modalStruk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Struk Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="strukContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCloseStruk">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnPrintStruk">Print</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Fungsi untuk format Rupiah tanpa desimal (SAMA PERSIS dengan yang di index)
    function formatRupiah(angka) {
        if (isNaN(angka) || angka === null || angka === undefined) return "Rp 0";
        return "Rp " + parseFloat(angka).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Fungsi untuk format angka tanpa prefix Rp (SAMA PERSIS dengan yang di index)
    function formatAngka(angka) {
        if (isNaN(angka) || angka === null || angka === undefined) return "0";
        return parseFloat(angka).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Fungsi untuk validasi angka (SAMA PERSIS dengan yang di index)
    function isValidNumber(value) {
        return !isNaN(value) && isFinite(value) && value !== null && value !== undefined;
    }

    // Fungsi untuk menghitung total per item (SAMA PERSIS dengan yang di index)
    function hitungTotalPerItem(harga_barang, quantity, diskonPersen, ppnPersen) {
        // Validasi input
        if (!isValidNumber(harga_barang) || !isValidNumber(quantity) || quantity <= 0) {
            return {
                subtotal: 0,
                nominalDiskon: 0,
                subtotalSetelahDiskon: 0,
                nominalPpn: 0,
                totalFinal: 0
            };
        }
        
        var subtotal = harga_barang * quantity;
        var nominalDiskon = (subtotal * diskonPersen) / 100;
        var subtotalSetelahDiskon = subtotal - nominalDiskon;
        var nominalPpn = (subtotalSetelahDiskon * ppnPersen) / 100;
        var totalFinal = subtotalSetelahDiskon + nominalPpn;
        
        return {
            subtotal: isValidNumber(subtotal) ? subtotal : 0,
            nominalDiskon: isValidNumber(nominalDiskon) ? nominalDiskon : 0,
            subtotalSetelahDiskon: isValidNumber(subtotalSetelahDiskon) ? subtotalSetelahDiskon : 0,
            nominalPpn: isValidNumber(nominalPpn) ? nominalPpn : 0,
            totalFinal: isValidNumber(totalFinal) ? totalFinal : 0
        };
    }

    // Fungsi untuk generate struk dengan perhitungan REAL-TIME dari keranjang
    function generateStrukRealTime() {
        var tanggal = new Date().toLocaleString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        // Ambil data real-time dari keranjang yang sedang aktif
        var cartItems = [];
        var grandTotal = 0;

        $('.cart-item').each(function() {
            var nm_barang = $(this).data('nm-barang');
            var option = $(`#nm_barang option[value="${nm_barang}"]`);
            
            var harga = parseFloat(option.data('harga_jual')) || 0;
            var diskonPersen = parseFloat(option.data('diskon')) || 0;
            var ppnPersen = parseFloat(option.data('ppn')) || 0;
            var quantity = parseInt($(this).find('.quantity').text()) || 0;
            
            // Gunakan fungsi perhitungan yang sama persis dengan index
            var perhitungan = hitungTotalPerItem(harga, quantity, diskonPersen, ppnPersen);
            grandTotal += perhitungan.totalFinal;
            
            cartItems.push({
                nm_barang: nm_barang,
                harga_barang: harga,
                quantity: quantity,
                diskon_persen: diskonPersen,
                ppn_persen: ppnPersen,
                perhitungan: perhitungan
            });
        });

        var strukHtml = `
        <div class="struk-container">
            <div class="struk-header">
                <div class="struk-title">SANSIN INDONESIA</div>
                <div class="struk-info">Jl.Sapan No 47</div>
                <div class="struk-info">Telp: 0812-3456-7890</div>
                <div class="struk-info">================================</div>
            </div>
            
            <div style="margin: 10px 0;">
                <div class="struk-info">No. Transaksi: PREVIEW-${Date.now()}</div>
                <div class="struk-info">Tanggal: ${tanggal}</div>
                <div class="struk-info">Kasir: <?php echo e(auth()->user()->name ?? 'Admin'); ?></div>
            </div>
            
            <div class="struk-separator"></div>
            
            <div id="strukItems">`;

        // Loop items dengan perhitungan yang konsisten
        cartItems.forEach(function(item, index) {
            strukHtml += `
            <div class="struk-item">
                <span>${item.nm_barang}</span>
            </div>
            <div class="struk-item-detail">
                ${item.quantity} x ${formatAngka(item.harga_barang)} = ${formatAngka(item.perhitungan.subtotal)}
            </div>`;
            
            // Tampilkan diskon per item jika ada
            if (item.diskon_persen > 0) {
                strukHtml += `
                <div class="struk-item-detail" style="color: #d32f2f;">
                    Diskon ${item.diskon_persen}%: -${formatAngka(item.perhitungan.nominalDiskon)}
                </div>`;
            }
            
            // Tampilkan PPN per item jika ada
            if (item.ppn_persen > 0) {
                strukHtml += `
                <div class="struk-item-detail" style="color: #1976d2;">
                    PPN ${item.ppn_persen}%: +${formatAngka(item.perhitungan.nominalPpn)}
                </div>`;
            }
            
            // Tampilkan total per item jika ada diskon atau PPN
            if (item.diskon_persen > 0 || item.ppn_persen > 0) {
                strukHtml += `
                <div class="struk-item-detail" style="font-weight: bold;">
                    Total: ${formatAngka(item.perhitungan.totalFinal)}
                </div>`;
            }
            
            strukHtml += `<div style="margin-bottom: 5px;"></div>`;
        });

        strukHtml += `
            </div>
            
            <div class="struk-separator"></div>`;

        // Tampilkan grand total
        strukHtml += `
            <div class="struk-item struk-total">
                <span>TOTAL:</span>
                <span>${formatAngka(grandTotal)}</span>
            </div>`;

        // Ambil nilai pembayaran real-time dari input
        var jumlahPembayaran = parseFloat($('#jumlah_pembayaran').val()) || 0;
        var uangKembalian = parseFloat($('#uang_kembalian').val()) || 0;

        if (jumlahPembayaran > 0) {
            strukHtml += `
            <div class="struk-item">
                <span>Tunai:</span>
                <span>${formatAngka(jumlahPembayaran)}</span>
            </div>
            
            <div class="struk-item">
                <span>Kembalian:</span>
                <span>${formatAngka(uangKembalian)}</span>
            </div>`;
        } else {
            strukHtml += `
            <div class="struk-item" style="color: #999;">
                <span>Tunai:</span>
                <span>-</span>
            </div>
            
            <div class="struk-item" style="color: #999;">
                <span>Kembalian:</span>
                <span>-</span>
            </div>`;
        }

        strukHtml += `
            <div class="struk-footer">
                <div style="margin: 10px 0;">================================</div>
                <div>TERIMA KASIH</div>
                <div>ATAS KUNJUNGAN ANDA</div>
                <div style="margin-top: 5px;">Barang yang sudah dibeli</div>
                <div>tidak dapat ditukar/dikembalikan</div>
            </div>
        </div>`;

        return strukHtml;
    }

    // Fungsi untuk generate struk dari data transaksi yang sudah selesai
    function generateStruk(data) {
        var tanggal = new Date().toLocaleString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        var strukHtml = `
        <div class="struk-container">
            <div class="struk-header">
                <div class="struk-title">SANSIN INDONESIA</div>
                <div class="struk-info">Jl.Sapan No 47</div>
                <div class="struk-info">Telp: 0812-3456-7890</div>
                <div class="struk-info">================================</div>
            </div>
            
            <div style="margin: 10px 0;">
                <div class="struk-info">No. Transaksi: ${data.kd_pembelian || 'TRX-' + Date.now()}</div>
                <div class="struk-info">Tanggal: ${tanggal}</div>
                <div class="struk-info">Kasir: <?php echo e(auth()->user()->name ?? 'Admin'); ?></div>
            </div>
            
            <div class="struk-separator"></div>
            
            <div id="strukItems">`;

        // Loop items dari data transaksi dengan perhitungan konsisten
        var grandTotal = 0;
        
        data.items.forEach(function(item, index) {
            // Validasi data item
            var harga = isValidNumber(item.harga_barang) ? parseFloat(item.harga_barang) : 0;
            var quantity = isValidNumber(item.quantity) ? parseInt(item.quantity) : 0;
            var diskonPersen = isValidNumber(item.diskon_persen) ? parseFloat(item.diskon_persen) : 0;
            var ppnPersen = isValidNumber(item.ppn_persen) ? parseFloat(item.ppn_persen) : 0;
            
            // Gunakan fungsi perhitungan yang sama persis dengan index
            var perhitungan = hitungTotalPerItem(harga, quantity, diskonPersen, ppnPersen);
            grandTotal += perhitungan.totalFinal;

            strukHtml += `
            <div class="struk-item">
                <span>${item.nm_barang}</span>
            </div>
            <div class="struk-item-detail">
                ${quantity} x ${formatAngka(harga)} = ${formatAngka(perhitungan.subtotal)}
            </div>`;
            
            // Tampilkan diskon per item jika ada
            if (diskonPersen > 0) {
                strukHtml += `
                <div class="struk-item-detail" style="color: #d32f2f;">
                    Diskon ${diskonPersen}%: -${formatAngka(perhitungan.nominalDiskon)}
                </div>`;
            }
            
            // Tampilkan PPN per item jika ada
            if (ppnPersen > 0) {
                strukHtml += `
                <div class="struk-item-detail" style="color: #1976d2;">
                    PPN ${ppnPersen}%: +${formatAngka(perhitungan.nominalPpn)}
                </div>`;
            }
            
            // Tampilkan total per item jika ada diskon atau PPN
            if (diskonPersen > 0 || ppnPersen > 0) {
                strukHtml += `
                <div class="struk-item-detail" style="font-weight: bold;">
                    Total: ${formatAngka(perhitungan.totalFinal)}
                </div>`;
            }
            
            strukHtml += `<div style="margin-bottom: 5px;"></div>`;
        });

        strukHtml += `
            </div>
            
            <div class="struk-separator"></div>
            
            <div class="struk-item struk-total">
                <span>TOTAL:</span>
                <span>${formatAngka(grandTotal)}</span>
            </div>`;

        // Validasi nilai pembayaran dan kembalian
        var jumlahPembayaran = isValidNumber(data.jumlah_pembayaran) ? parseFloat(data.jumlah_pembayaran) : 0;
        var uangKembalian = isValidNumber(data.uang_kembalian) ? parseFloat(data.uang_kembalian) : 0;

        strukHtml += `
            <div class="struk-item">
                <span>Tunai:</span>
                <span>${formatAngka(jumlahPembayaran)}</span>
            </div>
            
            <div class="struk-item">
                <span>Kembalian:</span>
                <span>${formatAngka(uangKembalian)}</span>
            </div>
            
            <div class="struk-footer">
                <div style="margin: 10px 0;">================================</div>
                <div>TERIMA KASIH</div>
                <div>ATAS KUNJUNGAN ANDA</div>
                <div style="margin-top: 5px;">Barang yang sudah dibeli</div>
                <div>tidak dapat ditukar/dikembalikan</div>
            </div>
        </div>`;

        return strukHtml;
    }

    // Fungsi untuk menampilkan preview struk real-time
    function showPreviewStruk() {
        // Cek apakah ada item di keranjang
        if ($('.cart-item').length === 0) {
            alert('Keranjang belanja masih kosong');
            return;
        }
        
        var strukHtml = generateStrukRealTime();
        $('#strukContent').html(strukHtml);
        
        // Buka modal struk
        $('#modalStruk').modal('show');
        
        // Hapus backdrop setelah modal muncul
        $('#modalStruk').on('shown.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
        });
    }

    // Fungsi untuk menampilkan struk setelah transaksi selesai
    function showStruk(kd_pembelian, transaksiData = null) {
        if (transaksiData) {
            // Validasi data transaksi sebelum generate struk
            if (!transaksiData.items || !Array.isArray(transaksiData.items) || transaksiData.items.length === 0) {
                console.error('Data transaksi tidak valid atau items kosong');
                alert('Gagal menampilkan struk: Data transaksi tidak valid');
                return;
            }
            
            var strukHtml = generateStruk(transaksiData);
            $('#strukContent').html(strukHtml);
            
            // Buka modal struk
            $('#modalStruk').modal('show');
            
            // Hapus backdrop setelah modal muncul
            $('#modalStruk').on('shown.bs.modal', function() {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            });
        } else {
            console.log('Fetch struk data for:', kd_pembelian);
        }
    }

    // Function untuk auto-update struk preview ketika ada perubahan di keranjang
    function autoUpdateStrukPreview() {
        if ($('#modalStruk').hasClass('show') && $('.cart-item').length > 0) {
            var strukHtml = generateStrukRealTime();
            $('#strukContent').html(strukHtml);
        }
    }

    // Event listeners untuk auto-update struk
    $(document).on('click', '.penambahan-quantity, .pengurangan-quantity', function() {
        setTimeout(autoUpdateStrukPreview, 100);
    });

    $(document).on('input', '#jumlah_pembayaran', function() {
        setTimeout(autoUpdateStrukPreview, 100);
    });

    $(document).on('click', '.remove-from-cart', function() {
        setTimeout(autoUpdateStrukPreview, 100);
    });

    // Tombol untuk show preview struk
    $(document).on('click', '#preview-struk', function() {
        showPreviewStruk();
    });

    function printStruk() {
        var strukContent = document.getElementById('strukContent').innerHTML;
        
        if (!strukContent || strukContent.trim() === '') {
            alert('Tidak ada struk untuk dicetak');
            return;
        }
        
        var printArea = document.createElement('div');
        printArea.setAttribute('id', 'printArea');
        printArea.innerHTML = strukContent;
        document.body.appendChild(printArea);
        
        var style = document.createElement('style');
        style.innerHTML = `
        @media print {
            body * {
                visibility: hidden !important;
            }
            #printArea, #printArea * {
                visibility: visible !important;
            }
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
            }
            .modal-backdrop, .modal, .modal-dialog {
                display: none !important;
            }
        }
        `;
        document.head.appendChild(style);
        
        window.print();
        
        setTimeout(function() {
            document.body.removeChild(printArea);
            document.head.removeChild(style);
        }, 1000);
    }

    // Event handlers
    $(document).on('click', '#btnPrintStruk', function() {
        printStruk();
    });
    
    $(document).on('click', '#btnCloseStruk', function() {
        $('#modalStruk').modal('hide');
    });

    $('#modalStruk').on('hidden.bs.modal', function() {
        $('#strukContent').html('');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');
    });

    // Expose functions to global scope
    window.showStruk = showStruk;
    window.generateStruk = generateStruk;
    window.printStruk = printStruk;
    window.showPreviewStruk = showPreviewStruk;
    window.generateStrukRealTime = generateStrukRealTime;
});
</script><?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/menu-penjualan/struk.blade.php ENDPATH**/ ?>