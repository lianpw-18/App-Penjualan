<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan</title>
    <style>
        .container {
            text-align: center;
            margin: auto;
        }

        .column {
            text-align: center;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        table {
            margin: auto;
            width: 100%;
            font-size: 12px;
        }

        tr {
            text-align: left;
        }

        table,
        th,
        td {
            border-collapse: collapse;
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            vertical-align: top;
        }

        th {
            background-color: gainsboro;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .summary-section {
            margin-top: 20px;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }

        .summary-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .summary-table td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        .summary-label {
            font-weight: bold;
            background-color: #f5f5f5;
            width: 60%;
        }

        .summary-value {
            text-align: right;
            font-weight: bold;
            width: 40%;
        }

        .pph-section {
            background-color: #fff3cd;
            border: 2px solid #ffeaa7;
        }

        .pph-section td {
            border-color: #ffeaa7;
        }

        .total-row {
            border-top: 2px solid black;
            background-color: #e8f5e8;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="column">
                <h2>S.A.N.S.I.N Indonesia</h2>
                <p>Jl.Sapan No 47<br> Kab. Bandung Jawa Barat</p>
                <hr style="width: 85%; text-align: center;">
                <h3 style="text-align: center;">Laporan Penjualan {{
                    ($tanggalMulai && $tanggalSelesai) ? 
                    date('d-m-Y', strtotime($tanggalMulai)) . ' - ' . date('d-m-Y', strtotime($tanggalSelesai)) : 
                    'Semua Range Tanggal' 
                }}
                @if($namaProdukFilter)
                    <br><small>Filter Produk: {{ $namaProdukFilter }}</small>
                @endif
                </h3>
            </div>
            <div class="col">
                <table id="table_id" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl Transaksi</th>
                            <th>Waktu Transaksi</th> <!-- Kolom baru untuk waktu -->
                            <th>Nama Produk</th>
                            <th>QTY</th>
                            <th>Total Diskon</th>
                            <th>Total PPn</th>
                            <th>Uang Masuk</th>
                            <th>Uang Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalUangMasuk = 0;
                        $totalUangKeluar = 0;
                        $totalDiskon = 0;
                        $totalPpn = 0;
                        $totalQty = 0;
                        ?>
                        @foreach ($data as $produk)
                        <?php
                        $uangMasuk = $produk->jumlah_pembayaran ?? 0;
                        $uangKeluar = $produk->uang_kembalian ?? 0;
                        
                        // PERBAIKAN: Gunakan nilai yang sudah dihitung di controller
                        $diskon = $produk->calculated_total_diskon ?? 0;
                        $ppn = $produk->calculated_total_ppn ?? 0;

                        // Calculate total quantity for this transaction
                        $qtyTransaction = 0;
                        if ($produk->detailPenjualans) {
                            foreach ($produk->detailPenjualans as $detail) {
                                $qtyTransaction += $detail->quantity ?? 0;
                            }
                        }

                        $totalUangMasuk += $uangMasuk;
                        $totalUangKeluar += $uangKeluar;
                        $totalDiskon += $diskon;
                        $totalPpn += $ppn;
                        $totalQty += $qtyTransaction;
                        
                        // Format waktu transaksi dari created_at
                        $waktuTransaksi = '-';
                        if ($produk->created_at) {
                            try {
                                $dateTime = new DateTime($produk->created_at);
                                $waktuTransaksi = $dateTime->format('H:i:s');
                            } catch (Exception $e) {
                                $waktuTransaksi = '-';
                            }
                        }
                        ?>
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ date('d-m-Y', strtotime($produk->tgl_transaksi)) }}</td>
                            <td class="text-center">{{ $waktuTransaksi }}</td> <!-- Kolom waktu transaksi -->
                            <td>
                                @if($produk->detailPenjualans && $produk->detailPenjualans->count() > 0)
                                @foreach ($produk->detailPenjualans as $detail)
                                {{ $detail->nm_produk }} ({{ $detail->quantity ?? 0 }})@if(!$loop->last), @endif
                                @endforeach
                                @else
                                Tidak ada detail produk
                                @endif
                            </td>
                            <td class="text-center">{{ $qtyTransaction }}</td>
                            <td class="text-right">Rp {{ number_format($diskon, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($ppn, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($uangMasuk, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($uangKeluar, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #f8f9fa; font-weight: bold;">
                            <td colspan="4" class="text-center"><strong>TOTAL</strong></td>
                            <td class="text-center"><strong>{{ $totalQty }}</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($totalDiskon, 0, ',', '.') }}</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($totalPpn, 0, ',', '.') }}</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($totalUangKeluar, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <!-- Ringkasan Total -->
            <table class="summary-table">
                <tr style="background-color: #f8f9fa;">
                    <td colspan="2" class="text-center" style="font-weight: bold; font-size: 14px;">RINGKASAN TOTAL</td>
                </tr>
                <tr>
                    <td class="summary-label">Total Uang Masuk:</td>
                    <td class="summary-value" style="color: green;">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="summary-label">Total Uang Keluar:</td>
                    <td class="summary-value" style="color: orange;">Rp {{ number_format($totalUangKeluar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="summary-label">Laba Kotor:</td>
                    <td class="summary-value" style="color: {{ ($totalUangMasuk - $totalUangKeluar) >= 0 ? 'green' : 'red' }};">
                        Rp {{ number_format($totalUangMasuk - $totalUangKeluar, 0, ',', '.') }}
                    </td>
                </tr>
            </table>

            <!-- PPh Final UMKM Section -->
            <?php
            $labaKotor = $totalUangMasuk - $totalUangKeluar;
            $pphFinalUMKM = $totalUangMasuk * 0.005; // 0.5% dari omzet
            $labaBersihSetelahPPh = $labaKotor - $pphFinalUMKM;
            ?>
            <table class="summary-table pph-section">
                <tr style="background-color: #fff3cd;">
                    <td colspan="2" class="text-center" style="font-weight: bold; font-size: 14px;">PPh FINAL UMKM (0,5% dari Omzet)</td>
                </tr>
                <tr>
                    <td class="summary-label">Total Omzet (Uang Masuk):</td>
                    <td class="summary-value">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="summary-label">PPh Final UMKM (0,5%):</td>
                    <td class="summary-value" style="color: orange;">Rp {{ number_format($pphFinalUMKM, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td class="summary-label">Laba Bersih Setelah PPh:</td>
                    <td class="summary-value" style="color: {{ $labaBersihSetelahPPh >= 0 ? 'green' : 'red' }};">
                        Rp {{ number_format($labaBersihSetelahPPh, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <br><br>
    <div style="width:100%; margin-top:40px; display: table;">
        <div style="width:50%; float:left; text-align:center;">
            <p>Pembuat Laporan,<br>Admin</p>
            <br><br><br>
            <p style="margin-top:60px;">(___________________)</p>
        </div>
        <div style="width:50%; float:right; text-align:center;">
            <p>Mengetahui,<br>Owner</p>
            <br><br><br>
            <p style="margin-top:60px;">(___________________)</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>

</html>