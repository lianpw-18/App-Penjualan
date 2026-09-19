<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PPN Keseluruhan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            line-height: 1.4;
        }
        
        .container {
            max-width: 100%;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .period {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }
        
        .summary-section {
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .summary-title {
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            color: #333;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .summary-row:last-child {
            border-bottom: none;
        }
        
        .summary-label {
            font-weight: bold;
            color: #555;
        }
        
        .summary-value {
            font-weight: bold;
        }
        
        .ppn-pengeluaran {
            color: #dc3545;
        }
        
        .ppn-pemasukan {
            color: #28a745;
        }
        
        .ppn-selisih-positif {
            color: #007bff;
        }
        
        .ppn-selisih-negatif {
            color: #fd7e14;
        }
        
        .total-section {
            background-color: #e9ecef;
            padding: 15px;
            margin-top: 15px;
            border-radius: 5px;
            border: 2px solid #333;
        }
        
        .total-section .summary-row {
            border-bottom: none;
            font-size: 14px;
        }
        
        .kewajiban-ppn {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #bee5eb;
        }
        
        .interpretation {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .interpretation-title {
            font-weight: bold;
            margin-bottom: 15px;
            color: #856404;
        }
        
        .interpretation p {
            margin-bottom: 10px;
            text-align: justify;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            background: white;
        }
        
        th {
            background-color: #5f27cd;
            color: white;
            padding: 12px 8px;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }
        
        td {
            padding: 10px 8px;
            text-align: center;
            border: 1px solid #dee2e6;
            font-size: 11px;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tfoot tr {
            background-color: #e9ecef;
            font-weight: bold;
        }
        
        tfoot td {
            padding: 12px 8px;
            border-top: 2px solid #333;
        }
        
        .no-data {
            text-align: center;
            padding: 50px 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin: 25px 0;
        }
        
        .no-data h3 {
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .no-data p {
            color: #6c757d;
        }
        
        .methodology {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-top: 30px;
            font-size: 10px;
            color: #6c757d;
        }
        
        .methodology-title {
            font-weight: bold;
            color: #495057;
            margin-bottom: 10px;
        }
        
        .methodology ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .methodology li {
            margin-bottom: 5px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }
        
        .footer div {
            margin-bottom: 3px;
        }
        
        @media print {
            body {
                padding: 15px;
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-name">SANSIN INDONESIA</div>
            <div class="report-title">LAPORAN PPN KESELURUHAN</div>
            <div class="period">
                @if($tanggalMulai && $tanggalSelesai)
                    Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}
                @else
                    Periode: Semua Data
                @endif
            </div>
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-title">RINGKASAN PPN</div>
            
            <div class="summary-row">
                <span class="summary-label">Total PPN Pengeluaran:</span>
                <span class="summary-value ppn-pengeluaran">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
            </div>
            
            <div class="summary-row">
                <span class="summary-label">Total PPN Pemasukan:</span>
                <span class="summary-value ppn-pemasukan">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
            </div>
            
            <div class="total-section">
                <div class="summary-row">
                    <span class="summary-label">TOTAL SELISIH:</span>
                    <span class="summary-value {{ $totalSelisih >= 0 ? 'ppn-selisih-positif' : 'ppn-selisih-negatif' }}">
                        Rp {{ number_format($totalSelisih, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            
            @if($totalSelisih > 0)
            <div class="kewajiban-ppn">
                PPN YANG HARUS DIBAYAR: Rp {{ number_format($totalSelisih, 0, ',', '.') }}
            </div>
            @endif
        </div>

        <!-- Interpretation Section -->
        <div class="interpretation">
            <div class="interpretation-title">INTERPRETASI HASIL</div>
            @if($totalSelisih > 0)
                <p><strong>Selisih Positif:</strong> Perusahaan memiliki kewajiban membayar PPN ke negara sebesar <strong>Rp {{ number_format($totalSelisih, 0, ',', '.') }}</strong> karena PPN Pengeluaran lebih besar dari PPN Pemasukan.</p>
                <p>Hal ini menunjukkan perusahaan melakukan lebih banyak aktivitas pembelian dibanding penjualan dalam periode ini.</p>
            @elseif($totalSelisih < 0)
                <p><strong>Selisih Negatif:</strong> Perusahaan berhak mendapat restitusi PPN dari negara sebesar <strong>Rp {{ number_format(abs($totalSelisih), 0, ',', '.') }}</strong> karena PPN Pemasukan lebih besar dari PPN Pengeluaran.</p>
                <p>Hal ini menunjukkan perusahaan melakukan lebih banyak aktivitas penjualan dibanding pembelian dalam periode ini.</p>
            @else
                <p><strong>Selisih Seimbang:</strong> PPN Pengeluaran dan PPN Pemasukan dalam keadaan seimbang, tidak ada kewajiban maupun hak restitusi PPN.</p>
            @endif
        </div>

        <!-- Data Table -->
        @if(count($data) > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 8%">No</th>
                    <th style="width: 20%">Tanggal</th>
                    <th style="width: 24%">PPN Pengeluaran</th>
                    <th style="width: 24%">PPN Pemasukan</th>
                    <th style="width: 24%">Selisih</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td class="ppn-pengeluaran">Rp {{ number_format($item->ppn_pengeluaran, 0, ',', '.') }}</td>
                    <td class="ppn-pemasukan">Rp {{ number_format($item->ppn_pemasukan, 0, ',', '.') }}</td>
                    <td class="{{ $item->selisih >= 0 ? 'ppn-selisih-positif' : 'ppn-selisih-negatif' }}">
                        Rp {{ number_format($item->selisih, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>TOTAL</strong></td>
                    <td class="ppn-pengeluaran"><strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
                    <td class="ppn-pemasukan"><strong>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</strong></td>
                    <td class="{{ $totalSelisih >= 0 ? 'ppn-selisih-positif' : 'ppn-selisih-negatif' }}">
                        <strong>Rp {{ number_format($totalSelisih, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>
        @else
        <div class="no-data">
            <h3>Data Tidak Ditemukan</h3>
            <p>Tidak ada data PPN untuk periode yang dipilih.</p>
        </div>
        @endif

        <!-- Methodology -->
        <div class="methodology">
            <div class="methodology-title">CATATAN METODOLOGI</div>
            <ul>
                <li>PPN Pengeluaran dihitung berdasarkan 11% dari harga beli barang yang keluar dari stok</li>
                <li>PPN Pemasukan dihitung berdasarkan 11% dari total harga barang yang masuk/dijual</li>
                <li>Data diambil dari tabel produk_keluars dan produk_masuks</li>
                <li>Perhitungan menggunakan rate PPN 11% sesuai ketentuan yang berlaku</li>
            </ul>
        </div>

        <div class="footer">
            <div><strong>Dicetak pada:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</div>
            <div>Laporan PPN Keseluruhan - Sistem Informasi Manajemen</div>
        </div>
    </div>
</body>
</html>