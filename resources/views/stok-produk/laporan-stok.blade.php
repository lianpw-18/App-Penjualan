<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .company-info {
            margin-bottom: 0;
        }
        
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #1a5276;
            margin: 0 0 5px 0;
            letter-spacing: 1px;
        }
        
        .company-contact {
            font-size: 11px;
            margin: 0;
            color: #555;
        }
        
        .company-address {
            font-size: 11px;
            margin: 0;
            color: #555;
        }
        
        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .report-title h1 {
            margin: 10px 0 5px;
            font-size: 18px;
            color: #333;
        }
        
        .report-title h2 {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-section p {
            margin: 5px 0;
            font-size: 11px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: black;
        }
        
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
        
        .summary {
            margin-top: 20px;
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        
        .summary h4 {
            margin: 0 0 10px 0;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <div class="company-name">S.A.N.S.I.N Indonesia</div>
            <p class="company-contact">Email: sansinindonesia@gmail.com | Telp: 085211178906</p>
            <p class="company-address">Jl. Sapan No 47, Kab. Bandung, Jawa Barat</p>
        </div>
    </div>
    
    <div class="report-title">
        <h1>LAPORAN STOK PRODUK</h1>
        <h2>
            @if($jenisStok == 'pembelian')
                Stok Pembelian
            @elseif($jenisStok == 'penjualan')
                Stok Penjualan
            @else
                Stok Pembelian & Penjualan
            @endif
        </h2>
    </div>
    
    <div class="info-section">
        <p><strong>Filter:</strong> 
            @if($selectedOption == 'semua')
                Semua Stok
            @elseif($selectedOption == 'minimum')
                Stok Batas Minimum (≤ 10)
            @elseif($selectedOption == 'stok-habis')
                Stok Habis (0)
            @endif
        </p>
        <p><strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i:s') }}</p>
        <p><strong>Total Data:</strong> {{ count($stokData) }} item</p>
    </div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Kode Barang</th>
                <th width="20%">Nama Barang</th>
            
                <th width="8%">Jenis</th>
                <th width="8%">Stok</th>
                <th width="12%">Harga Beli</th>
                <th width="12%">Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stokData as $index => $barang)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $barang['kd_barang'] }}</td>
                    <td>{{ $barang['nm_barang'] }}</td>
                    
                    <td class="text-center">
                        <span class="badge {{ $barang['jenis'] == 'Pembelian' ? 'badge-info' : 'badge-success' }}">
                            {{ $barang['jenis'] }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $barang['stok'] == 0 ? 'badge-danger' : ($barang['stok'] <= 10 ? 'badge-warning' : 'badge-success') }}">
                            {{ $barang['stok'] }}
                        </span>
                    </td>
                    <td class="text-right">Rp {{ number_format($barang['harga_beli'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($barang['harga_jual'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data yang tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if(count($stokData) > 0)
        <div class="summary">
            <h4>RINGKASAN:</h4>
            @php
                $totalPembelian = collect($stokData)->where('jenis', 'Pembelian')->count();
                $totalPenjualan = collect($stokData)->where('jenis', 'Penjualan')->count();
                $stokHabis = collect($stokData)->where('stok', 0)->count();
                $stokMinimum = collect($stokData)->where('stok', '<=', 10)->where('stok', '>', 0)->count();
                $totalStok = collect($stokData)->sum('stok');
                $totalNilaiPembelian = collect($stokData)->sum(function($item) {
                    return $item['stok'] * $item['harga_beli'];
                });
                $totalNilaiPenjualan = collect($stokData)->sum(function($item) {
                    return $item['stok'] * $item['harga_jual'];
                });
            @endphp
            
            <p><strong>Total Barang Pembelian:</strong> {{ $totalPembelian }} item</p>
            <p><strong>Total Barang Penjualan:</strong> {{ $totalPenjualan }} item</p>
            <p><strong>Total Stok Keseluruhan:</strong> {{ number_format($totalStok) }} unit</p>
            <p><strong>Barang Stok Habis:</strong> {{ $stokHabis }} item</p>
            <p><strong>Barang Stok Minimum:</strong> {{ $stokMinimum }} item</p>
            <p><strong>Total Nilai Pembelian:</strong> Rp {{ number_format($totalNilaiPembelian, 0, ',', '.') }}</p>
            <p><strong>Total Nilai Penjualan:</strong> Rp {{ number_format($totalNilaiPenjualan, 0, ',', '.') }}</p>
        </div>
    @endif
    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <p>Sistem Manajemen Stok</p>
    </div>
</body>
</html>