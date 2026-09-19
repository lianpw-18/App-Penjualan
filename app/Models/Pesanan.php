<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'ongkir' => 'decimal:2',
        'subtotal_produk' => 'decimal:2',
        'total_diskon' => 'decimal:2',
        'total_ppn' => 'decimal:2',
        'total_bayar' => 'decimal:2',
        'tgl_pembayaran' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function getFormattedTotalBayarAttribute()
    {
        return 'Rp ' . number_format($this->total_bayar, 0, ',', '.');
    }

    public function getFormattedOngkirAttribute()
    {
        return 'Rp ' . number_format($this->ongkir, 0, ',', '.');
    }

    public function getFormattedSubtotalProdukAttribute()
    {
        return 'Rp ' . number_format($this->subtotal_produk, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        switch ($this->status_pesanan) {
            case 'menunggu_pembayaran':
                return '<span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i>Menunggu Pembayaran</span>';
            case 'diproses':
                return '<span class="badge bg-info text-dark"><i class="fa-solid fa-box-open me-1"></i>Sedang Dikemas</span>';
            case 'dikirim':
                return '<span class="badge bg-primary"><i class="fa-solid fa-truck-fast me-1"></i>Sedang Dikirim</span>';
            case 'selesai':
                return '<span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i>Selesai</span>';
            case 'dibatalkan':
                return '<span class="badge bg-danger"><i class="fa-solid fa-circle-xmark me-1"></i>Dibatalkan</span>';
            default:
                return '<span class="badge bg-secondary">' . ucfirst($this->status_pesanan) . '</span>';
        }
    }

    public function getMetodePembayaranLabelAttribute()
    {
        $labels = [
            'transfer_bca'     => 'Transfer Bank BCA',
            'transfer_mandiri' => 'Transfer Bank Mandiri',
            'transfer_bri'     => 'Transfer Bank BRI',
            'transfer_bni'     => 'Transfer Bank BNI',
            'qris'             => 'QRIS (GoPay, OVO, Dana, ShopeePay)',
            'cod'              => 'COD (Bayar di Tempat)',
        ];

        return $labels[$this->metode_pembayaran] ?? strtoupper($this->metode_pembayaran);
    }

    /**
     * Generate dynamic courier tracking steps (Tokopedia-style)
     */
    public function getTrackingTimeline()
    {
        $createdAt = $this->created_at;
        $tglBayar = $this->tgl_pembayaran ?? $createdAt->copy()->addMinutes(15);
        $courierName = $this->ekspedisi ?: 'Kurir Ekspedisi';
        $destCity = $this->kota ?: 'Kota Tujuan';
        $destKec = $this->kecamatan ?: '';

        $steps = [];

        // 1. Pesanan Dibuat
        $steps[] = [
            'status'      => 'completed',
            'title'       => 'Pesanan Berhasil Dibuat',
            'time'        => $createdAt->format('d M Y, H:i') . ' WIB',
            'location'    => 'Sistem Butik Gamis',
            'description' => 'Pesanan dengan no invoice ' . $this->no_pesanan . ' telah berhasil tercatat.',
            'icon'        => 'fa-clipboard-check',
        ];

        // 2. Pembayaran
        if ($this->metode_pembayaran === 'cod') {
            $steps[] = [
                'status'      => 'completed',
                'title'       => 'Metode COD Terverifikasi',
                'time'        => $createdAt->format('d M Y, H:i') . ' WIB',
                'location'    => 'Sistem Pembayaran',
                'description' => 'Pesanan dikonfirmasi dengan metode Bayar di Tempat (COD). Siapkan uang pas saat barang tiba.',
                'icon'        => 'fa-hand-holding-dollar',
            ];
        } else {
            $isPaid = in_array($this->status_pesanan, ['diproses', 'dikirim', 'selesai']);
            $steps[] = [
                'status'      => $isPaid ? 'completed' : 'pending',
                'title'       => $isPaid ? 'Pembayaran Berhasil Dikonfirmasi' : 'Menunggu Pembayaran',
                'time'        => $isPaid ? $tglBayar->format('d M Y, H:i') . ' WIB' : 'Menunggu Transfer',
                'location'    => 'Payment Gateway',
                'description' => $isPaid 
                    ? 'Pembayaran sebesar ' . $this->formatted_total_bayar . ' telah diverifikasi oleh sistem.'
                    : 'Silakan selesaikan pembayaran sesuai instruksi untuk memproses pengiriman.',
                'icon'        => 'fa-credit-card',
            ];
        }

        // 3. Sedang Dikemas
        $isPackaging = in_array($this->status_pesanan, ['diproses', 'dikirim', 'selesai']);
        $steps[] = [
            'status'      => $isPackaging ? 'completed' : 'pending',
            'title'       => 'Pesanan Sedang Dikemas',
            'time'        => $isPackaging ? $tglBayar->copy()->addMinutes(45)->format('d M Y, H:i') . ' WIB' : '-',
            'location'    => 'Gudang Pengemasan Butik',
            'description' => $isPackaging 
                ? 'Penjual sedang memeriksa kualitas pakaian gamis, mengemas aman, dan mencetak resi pengiriman.'
                : 'Menunggu proses pengemasan oleh penjual.',
            'icon'        => 'fa-box',
        ];

        // 4. Diserahkan ke Kurir & Resi Terbit
        $isHandedOver = in_array($this->status_pesanan, ['dikirim', 'selesai']) || !empty($this->no_resi);
        $steps[] = [
            'status'      => $isHandedOver ? 'completed' : ($this->status_pesanan === 'diproses' ? 'current' : 'pending'),
            'title'       => $isHandedOver ? 'Paket Diserahkan ke ' . $courierName : 'Menunggu Penjemputan Kurir',
            'time'        => $isHandedOver ? $tglBayar->copy()->addHours(3)->format('d M Y, H:i') . ' WIB' : '-',
            'location'    => 'Drop Point ' . $courierName,
            'description' => $isHandedOver 
                ? 'Paket telah di-drop / di-pick up oleh kurir ' . $courierName . '. No. Resi: ' . ($this->no_resi ?: 'Dalam proses scan barcode.')
                : 'Paket dijadwalkan diserahkan ke counter agen ' . $courierName . '.',
            'icon'        => 'fa-truck-ramp-box',
        ];

        // 5. Sedang Dalam Perjalanan (On Transit)
        $isOnTransit = in_array($this->status_pesanan, ['dikirim', 'selesai']);
        $steps[] = [
            'status'      => $isOnTransit ? 'completed' : 'pending',
            'title'       => 'Paket Dalam Perjalanan (On Transit)',
            'time'        => $isOnTransit ? $tglBayar->copy()->addHours(7)->format('d M Y, H:i') . ' WIB' : '-',
            'location'    => 'Sorting Hub ' . $courierName,
            'description' => $isOnTransit 
                ? 'Paket telah keluar dari Sorting Center dan diberangkatkan menuju kota tujuan (' . $destCity . ').'
                : 'Paket akan diberangkatkan ke kota tujuan.',
            'icon'        => 'fa-truck-fast',
        ];

        // 6. Tiba di Hub / Drop Point Kota Tujuan
        $isArrivedHub = in_array($this->status_pesanan, ['dikirim', 'selesai']);
        $steps[] = [
            'status'      => $isArrivedHub ? ($this->status_pesanan === 'selesai' ? 'completed' : 'current') : 'pending',
            'title'       => 'Tiba di Fasilitas Logistik Terdekat',
            'time'        => $isArrivedHub ? $tglBayar->copy()->addHours(18)->format('d M Y, H:i') . ' WIB' : '-',
            'location'    => ($destKec ? $destKec . ', ' : '') . $destCity,
            'description' => $isArrivedHub 
                ? 'Paket telah tiba di gerai / warehouse ' . $courierName . ' terdekat dan siap disortir ke kurir pengantar.'
                : 'Paket akan tiba di fasilitas kurir kota tujuan.',
            'icon'        => 'fa-warehouse',
        ];

        // 7. Sedang Diantar ke Alamat Penerima
        $isDelivering = in_array($this->status_pesanan, ['dikirim', 'selesai']);
        $steps[] = [
            'status'      => ($this->status_pesanan === 'selesai') ? 'completed' : ($this->status_pesanan === 'dikirim' ? 'current' : 'pending'),
            'title'       => 'Kurir Sedang Mengantar ke Alamat',
            'time'        => $isDelivering ? $tglBayar->copy()->addHours(22)->format('d M Y, H:i') . ' WIB' : '-',
            'location'    => 'Wilayah Pengantaran ' . ($destKec ?: $destCity),
            'description' => $isDelivering 
                ? 'Kurir ' . $courierName . ' sedang menuju alamat penerima: ' . $this->alamat_lengkap . '. Pastikan no telepon ' . $this->no_telepon . ' dapat dihubungi.'
                : 'Kurir akan membawa paket menuju alamat tujuan.',
            'icon'        => 'fa-motorcycle',
        ];

        // 8. Paket Diterima
        $isDone = ($this->status_pesanan === 'selesai');
        $steps[] = [
            'status'      => $isDone ? 'completed' : 'pending',
            'title'       => $isDone ? 'Paket Berhasil Diterima' : 'Menunggu Diterima',
            'time'        => $isDone ? $this->updated_at->format('d M Y, H:i') . ' WIB' : 'Estimasi tiba: ' . $this->estimasi_pengiriman,
            'location'    => $this->alamat_lengkap,
            'description' => $isDone 
                ? 'Paket telah diterima dengan baik oleh ' . $this->nama_penerima . ' / penerima di alamat tujuan.'
                : 'Paket diperkirakan tiba dalam ' . $this->estimasi_pengiriman . '.',
            'icon'        => 'fa-house-circle-check',
        ];

        return $steps;
    }
}
