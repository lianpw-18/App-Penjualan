<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingPenjualan;
use App\Http\Controllers\Controller;

class SettingPenjualanController extends Controller
{
    public function index()
    {
        $settingPenjualan = SettingPenjualan::first();
        return view('setting-penjualan.index', [
            'settingPenjualan'  => $settingPenjualan
        ]);
    }

    // Method ini bisa dihapus karena diskon dan PPN sudah pindah ke masing-masing barang
    // Tapi tetap dipertahankan untuk kompatibilitas jika masih ada setting lain
    public function updateSetting(Request $request)
    {
        $settingPenjualan = SettingPenjualan::first();
        
        // Update hanya setting yang tidak terkait diskon/PPN
        // Misalnya setting lain seperti format nota, dll
        $settingPenjualan->update([
            // Hapus diskon_enabled, diskon_presentase, ppn_enabled, ppn_presentase
            // Karena sudah dipindah ke per barang
            // Bisa tambahkan setting lain jika ada
        ]);

        return response()->json(['message' => 'Pengaturan berhasil diperbarui']);
    }
}