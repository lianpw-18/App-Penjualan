@php $no = 1; @endphp
@foreach ($data as $item)
    <tr>
        <td class="text-center font-weight-bold text-muted">{{ $no++ }}</td>
        <td>
            <span class="badge badge-primary">
                <i class="fas fa-barcode mr-1" style="font-size: 0.7rem;"></i>{{ $item->kd_penjualan_barang }}
            </span>
        </td>
        <td>
            <div class="font-weight-bold text-dark">{{ $item->nm_barang }}</div>
            @if($item->kategori)
                <small class="text-muted">{{ $item->kategori->kategori ?? $item->kategori->nm_kategori ?? '' }}</small>
            @endif
        </td>
        <td>
            <span class="text-muted font-weight-bold" style="font-size: 0.86rem;">
                Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
            </span>
        </td>
        <td>
            <span class="text-success font-weight-bold" style="font-size: 0.92rem;">
                Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
            </span>
        </td>
        <td class="text-center">
            <span class="badge badge-{{ $item->stok > 10 ? 'success' : ($item->stok > 0 ? 'warning' : 'danger') }}">
                <i class="fas fa-circle mr-1" style="font-size: 0.4rem;"></i>{{ $item->stok }}
            </span>
        </td>
        <td class="text-center">
            @if($item->diskon_persen > 0)
                <span class="badge badge-info">{{ rtrim(rtrim(number_format($item->diskon_persen, 2), '0'), '.') }}%</span>
            @else
                <span class="text-muted" style="font-size: 0.85rem;">-</span>
            @endif
        </td>
        <td class="text-center">
            <span class="badge badge-warning">{{ rtrim(rtrim(number_format($item->ppn_persen, 2), '0'), '.') }}%</span>
        </td>
        <td class="text-center">
            <div class="action-btn-group justify-content-center">
                <!-- Edit Button -->
                <button class="btn-action btn-action-edit edit-btn" 
                        data-id="{{ $item->id }}"
                        data-nm_barang="{{ $item->nm_barang }}"
                        data-deskripsi="{{ $item->deskripsi }}"
                        data-kategori_id="{{ $item->kategori_id }}"
                        data-satuan_id="{{ $item->satuan_id }}"
                        data-harga_jual="{{ $item->harga_jual }}"
                        data-harga_beli="{{ $item->harga_beli }}"
                        data-stok="{{ $item->stok }}"
                        data-diskon_persen="{{ $item->diskon_persen }}"
                        data-ppn_persen="{{ $item->ppn_persen }}"
                        title="Edit Produk"
                        data-toggle="tooltip">
                    <i class="fa fa-pen"></i>
                </button>
                <!-- Detail Button -->
                <button class="btn-action btn-action-view detail-btn" 
                        data-id="{{ $item->id }}" 
                        title="Lihat Detail"
                        data-toggle="tooltip">
                    <i class="fa fa-eye"></i>
                </button>
                <!-- Delete Button -->
                <button class="btn-action btn-action-delete delete-btn" 
                        data-id="{{ $item->id }}" 
                        title="Hapus Produk"
                        data-toggle="tooltip">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach
<script>
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>