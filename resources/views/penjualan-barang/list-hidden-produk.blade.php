@php $no = 1; @endphp
@foreach ($data as $item)
    <tr>
        <td>{{ $no++ }}</td>
        <td>
            <span class="badge badge-secondary">{{ $item->kd_penjualan_barang }}</span>
        </td>
        <td>
            <strong class="text-muted">{{ $item->nm_barang }}</strong>
        </td>
        <td>
            <span class="text-danger">Rp. {{ number_format($item->harga_beli, 0, ',', '.') }}</span>
        </td>
        <td>
            <span class="text-success">Rp. {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
        </td>
        <td>
            <span class="badge badge-secondary">{{ $item->stok }}</span>
        </td>
        <td>
            <div class="btn-group" role="group" aria-label="Action buttons">
                <!-- Restore Button -->
                <button class="btn btn-success btn-sm restore-btn" 
                        data-id="{{ $item->id }}" 
                        title="Kembalikan Produk"
                        data-toggle="tooltip">
                    <i class="fa fa-undo"></i>
                </button>
                <!-- Force Delete Button -->
                <button class="btn btn-danger btn-sm force-delete-btn" 
                        data-id="{{ $item->id }}" 
                        title="Hapus Permanen"
                        data-toggle="tooltip">
                    <i class="fa fa-trash-alt"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach

@if($data->count() == 0)
    <tr>
        <td colspan="7" class="text-center text-muted">
            <i class="fa fa-info-circle"></i> Tidak ada produk tersembunyi
        </td>
    </tr>
@endif