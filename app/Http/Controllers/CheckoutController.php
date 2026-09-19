<?php

namespace App\Http\Controllers;

use App\Models\PenjualanBarang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\SettingPenjualan;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display Tokopedia-style checkout page
     */
    public function index(Request $request)
    {
        $setting = SettingPenjualan::first();
        $singleProductId = $request->input('product_id');
        $singleQty = max(1, (int)$request->input('qty', 1));

        $directProduct = null;
        if ($singleProductId) {
            $directProduct = PenjualanBarang::visible()->findOrFail($singleProductId);
        }

        // Fetch all 38 provinces from Laravolt Indonesia
        $provinces = Province::orderBy('name', 'asc')->get(['code', 'name']);

        return view('checkout.index', compact('setting', 'directProduct', 'singleQty', 'provinces'));
    }

    /**
     * AJAX Get Cities by Province Code (Laravolt)
     */
    public function getCities(Request $request)
    {
        $provinceCode = $request->query('province_code');
        $cities = City::where('province_code', $provinceCode)
            ->orderBy('name', 'asc')
            ->get(['code', 'name']);

        return response()->json($cities);
    }

    /**
     * AJAX Get Districts by City Code (Laravolt)
     */
    public function getDistricts(Request $request)
    {
        $cityCode = $request->query('city_code');
        $districts = District::where('city_code', $cityCode)
            ->orderBy('name', 'asc')
            ->get(['code', 'name']);

        return response()->json($districts);
    }

    /**
     * AJAX Get Villages by District Code (Laravolt)
     */
    public function getVillages(Request $request)
    {
        $districtCode = $request->query('district_code');
        $villages = Village::where('district_code', $districtCode)
            ->orderBy('name', 'asc')
            ->get(['code', 'name', 'meta']);

        return response()->json($villages);
    }

    /**
     * Dynamic Shipping Rate Calculator (Tokopedia-style)
     */
    public function calculateShipping(Request $request)
    {
        $provinsi = $request->input('provinsi', 'JAWA TENGAH');
        $kota = $request->input('kota', 'KABUPATEN PURWOREJO');
        $totalWeightKg = max(1, (float)$request->input('weight_kg', 1));

        // Base rates by region
        $baseRate = 12000;
        $provLower = strtolower($provinsi);
        $kotaLower = strtolower($kota);

        if (str_contains($provLower, 'jawa tengah') || str_contains($kotaLower, 'purworejo') || str_contains($kotaLower, 'yogyakarta') || str_contains($provLower, 'yogyakarta')) {
            $baseRate = 9000;
        } elseif (str_contains($provLower, 'jakarta') || str_contains($provLower, 'jawa barat') || str_contains($provLower, 'banten')) {
            $baseRate = 13000;
        } elseif (str_contains($provLower, 'jawa timur')) {
            $baseRate = 14000;
        } else {
            $baseRate = 28000;
        }

        $multiplier = ceil($totalWeightKg);

        $couriers = [
            [
                'code' => 'JNE',
                'name' => 'JNE Express',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/9/92/New_Logo_JNE.png',
                'services' => [
                    [
                        'id'       => 'jne_reg',
                        'service'  => 'JNE REG (Reguler)',
                        'etd'      => '1-3 Hari',
                        'cost'     => (int)($baseRate * $multiplier),
                        'desc'     => 'Pengiriman reguler terpercaya',
                    ],
                    [
                        'id'       => 'jne_yes',
                        'service'  => 'JNE YES (Yakin Esok Sampai)',
                        'etd'      => '1 Hari (Besok Sampai)',
                        'cost'     => (int)(($baseRate + 12000) * $multiplier),
                        'desc'     => 'Prioritas express cepat sampai',
                    ],
                ]
            ],
            [
                'code' => 'J&T',
                'name' => 'J&T Express',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/J%26T_Express_logo.svg/1200px-J%26T_Express_logo.svg.png',
                'services' => [
                    [
                        'id'       => 'jnt_ez',
                        'service'  => 'J&T EZ (Reguler)',
                        'etd'      => '1-2 Hari',
                        'cost'     => (int)(($baseRate + 1000) * $multiplier),
                        'desc'     => 'Antar cepat setiap hari tanpa libur',
                    ],
                    [
                        'id'       => 'jnt_super',
                        'service'  => 'J&T Super (Express)',
                        'etd'      => '1 Hari',
                        'cost'     => (int)(($baseRate + 14000) * $multiplier),
                        'desc'     => 'Layanan kilat garansi tepat waktu',
                    ],
                ]
            ],
            [
                'code' => 'SICEPAT',
                'name' => 'SiCepat Ekspres',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ab/Logo_SiCepat_Ekspres.png/800px-Logo_SiCepat_Ekspres.png',
                'services' => [
                    [
                        'id'       => 'sicepat_best',
                        'service'  => 'SiCepat BEST (Besok Sampai)',
                        'etd'      => '1 Hari',
                        'cost'     => (int)(($baseRate + 10000) * $multiplier),
                        'desc'     => 'Besok Sampai Tujuan',
                    ],
                    [
                        'id'       => 'sicepat_reg',
                        'service'  => 'SiCepat SIUNTUNG (Reguler)',
                        'etd'      => '2-3 Hari',
                        'cost'     => (int)(($baseRate - 1000 > 8000 ? $baseRate - 1000 : 8000) * $multiplier),
                        'desc'     => 'Tarif hemat ekonomis',
                    ],
                ]
            ],
            [
                'code' => 'POS',
                'name' => 'Pos Indonesia',
                'logo' => 'https://upload.wikimedia.org/wikipedia/id/thumb/0/00/Pos-Indonesia-Logo.png/800px-Pos-Indonesia-Logo.png',
                'services' => [
                    [
                        'id'       => 'pos_kilat',
                        'service'  => 'Pos Kilat Khusus',
                        'etd'      => '2-4 Hari',
                        'cost'     => (int)(($baseRate - 2000 > 7500 ? $baseRate - 2000 : 7500) * $multiplier),
                        'desc'     => 'Jangkauan hingga pelosok nusantara',
                    ],
                ]
            ],
        ];

        return response()->json([
            'success' => true,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'weight_kg' => $totalWeightKg,
            'couriers' => $couriers,
        ]);
    }

    /**
     * Store new customer order directly
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_penerima'   => 'required|string|max:150',
            'no_telepon'      => 'required|string|max:20',
            'alamat_lengkap'  => 'required|string',
            'provinsi'        => 'required|string',
            'kota'            => 'required|string',
            'kecamatan'       => 'nullable|string|max:100',
            'kelurahan'       => 'nullable|string|max:100',
            'ekspedisi'       => 'required|string',
            'layanan_ekspedisi' => 'required|string',
            'ongkir'          => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string',
            'items'           => 'required|array|min:1',
            'items.*.id'      => 'required|exists:penjualan_barangs,id',
            'items.*.qty'     => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $subtotalProduk = 0;
            $totalDiskon = 0;
            $itemsToProcess = [];

            // Check stock and calculate product totals
            foreach ($request->items as $itemData) {
                $product = PenjualanBarang::lockForUpdate()->find($itemData['id']);

                if (!$product) {
                    throw new \Exception("Produk tidak ditemukan.");
                }

                if ($product->stok < $itemData['qty']) {
                    throw new \Exception("Stok untuk produk '{$product->nm_barang}' tidak mencukupi (sisa: {$product->stok}).");
                }

                $hargaSatuan = (float)$product->harga_jual;
                $diskonPersen = (float)($product->diskon_persen ?? 0);
                $diskonNominal = ($hargaSatuan * $diskonPersen / 100);
                $hargaSetelahDiskon = $hargaSatuan - $diskonNominal;
                $itemSubtotal = $hargaSetelahDiskon * $itemData['qty'];

                $subtotalProduk += ($hargaSatuan * $itemData['qty']);
                $totalDiskon += ($diskonNominal * $itemData['qty']);

                // Deduct stock
                $product->stok -= $itemData['qty'];
                $product->save();

                $itemsToProcess[] = [
                    'product' => $product,
                    'qty' => $itemData['qty'],
                    'harga_satuan' => $hargaSatuan,
                    'diskon_persen' => $diskonPersen,
                    'subtotal' => $itemSubtotal,
                ];
            }

            // PPN calculation
            $setting = SettingPenjualan::first();
            $ppnPersen = ($setting && $setting->ppn_enabled) ? ($setting->ppn_presentase ?? 11) : 0;
            $dpp = $subtotalProduk - $totalDiskon;
            $totalPpn = ($dpp * $ppnPersen / 100);

            $ongkir = (float)$request->ongkir;
            $totalBayar = $dpp + $totalPpn + $ongkir;

            // Generate unique Tokopedia-style invoice number: INV/YYYYMMDD/MPL/RANDOM
            $dateCode = date('Ymd');
            $randomCode = strtoupper(substr(uniqid(), -5));
            $noPesanan = "INV/{$dateCode}/BUTIK/{$randomCode}";

            // Create Order
            $pesanan = Pesanan::create([
                'no_pesanan'        => $noPesanan,
                'user_id'           => Auth::id(),
                'nama_penerima'     => $request->nama_penerima,
                'no_telepon'        => $request->no_telepon,
                'alamat_lengkap'    => $request->alamat_lengkap,
                'provinsi'          => $request->provinsi,
                'kota'              => $request->kota,
                'kecamatan'         => $request->kecamatan,
                'kelurahan'         => $request->kelurahan,
                'kode_pos'          => $request->kode_pos,
                'catatan'           => $request->catatan,
                'ekspedisi'         => $request->ekspedisi,
                'layanan_ekspedisi' => $request->layanan_ekspedisi,
                'ongkir'            => $ongkir,
                'estimasi_pengiriman' => $request->estimasi_pengiriman ?? '1-3 Hari',
                'subtotal_produk'   => $subtotalProduk,
                'total_diskon'      => $totalDiskon,
                'total_ppn'         => $totalPpn,
                'total_bayar'       => $totalBayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pesanan'    => ($request->metode_pembayaran === 'cod') ? 'diproses' : 'menunggu_pembayaran',
            ]);

            // Create Order Items
            foreach ($itemsToProcess as $item) {
                DetailPesanan::create([
                    'pesanan_id'          => $pesanan->id,
                    'penjualan_barang_id' => $item['product']->id,
                    'nm_barang'           => $item['product']->nm_barang,
                    'harga_satuan'        => $item['harga_satuan'],
                    'jumlah'              => $item['qty'],
                    'diskon_persen'       => $item['diskon_persen'],
                    'subtotal'            => $item['subtotal'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Pesanan berhasil dibuat!',
                'no_pesanan'   => $pesanan->no_pesanan,
                'redirect_url' => route('checkout.success', ['no_pesanan' => $pesanan->no_pesanan]),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Success Invoice Page
     */
    public function success($no_pesanan)
    {
        $pesanan = Pesanan::with(['detailPesanans.penjualanBarang', 'user'])
            ->where('no_pesanan', $no_pesanan)
            ->firstOrFail();

        // Bank Accounts details
        $bankAccounts = [
            'transfer_bca' => [
                'bank' => 'BCA',
                'no_rek' => '8920-1928-3341',
                'an' => 'BUTIK GAMIS SYAR\'I PURWOREJO',
                'badge' => 'bg-primary',
            ],
            'transfer_mandiri' => [
                'bank' => 'Bank Mandiri',
                'no_rek' => '137-00-1928374-1',
                'an' => 'BUTIK GAMIS SYAR\'I',
                'badge' => 'bg-warning text-dark',
            ],
            'transfer_bri' => [
                'bank' => 'BRI',
                'no_rek' => '0129-01-082736-50-8',
                'an' => 'SITI BUTIK BUSANA',
                'badge' => 'bg-info text-dark',
            ],
            'transfer_bni' => [
                'bank' => 'BNI',
                'no_rek' => '0829-1827-39',
                'an' => 'BUTIK SYAR\'I INDONESIA',
                'badge' => 'bg-success',
            ],
        ];

        // WhatsApp Confirmation URL builder
        $waMessage = "Halo Admin Butik, saya telah membuat pesanan di web:\n" .
                     "No. Pesanan: {$pesanan->no_pesanan}\n" .
                     "Penerima: {$pesanan->nama_penerima}\n" .
                     "Total Tagihan: {$pesanan->formatted_total_bayar}\n" .
                     "Metode: {$pesanan->metode_pembayaran_label}\n" .
                     "Kurir: {$pesanan->ekspedisi} ({$pesanan->layanan_ekspedisi})\n\n" .
                     "Mohon informasi konfirmasi dan proses pengirimannya ya kak. Terima kasih!";
        
        $waConfirmUrl = "https://wa.me/6281234567890?text=" . urlencode($waMessage);

        return view('checkout.success', compact('pesanan', 'bankAccounts', 'waConfirmUrl'));
    }

    /**
     * AJAX Get Live Courier Tracking Information by Invoice Number
     */
    public function tracking($no_pesanan)
    {
        $pesanan = Pesanan::with(['detailPesanans'])
            ->where('no_pesanan', $no_pesanan)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'order' => [
                'id'                  => $pesanan->id,
                'no_pesanan'          => $pesanan->no_pesanan,
                'ekspedisi'           => $pesanan->ekspedisi,
                'layanan_ekspedisi'   => $pesanan->layanan_ekspedisi,
                'no_resi'             => $pesanan->no_resi,
                'nama_penerima'       => $pesanan->nama_penerima,
                'no_telepon'          => $pesanan->no_telepon,
                'alamat_lengkap'      => $pesanan->alamat_lengkap . ($pesanan->kelurahan ? ', Kel. ' . $pesanan->kelurahan : '') . ($pesanan->kecamatan ? ', Kec. ' . $pesanan->kecamatan : '') . ', ' . $pesanan->kota . ', ' . $pesanan->provinsi . ' ' . $pesanan->kode_pos,
                'status_pesanan'      => $pesanan->status_pesanan,
                'status_badge'        => $pesanan->status_badge,
                'estimasi_pengiriman' => $pesanan->estimasi_pengiriman,
                'total_bayar'         => $pesanan->formatted_total_bayar,
                'metode_pembayaran'   => $pesanan->metode_pembayaran_label,
            ],
            'timeline' => $pesanan->getTrackingTimeline(),
        ]);
    }
}
