@foreach ($produkMasuk as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->kd_transaksi }}</td>
        <td>{{ $item->nm_produk }}</td>
        <td>{{ $item->tgl_masuk }}</td>
        <td>{{ $item->stok_masuk }}</td>
        <td>{{ $item->harga_beli }}</td>
        <td>{{ $item->total_harga }}</td>
        <td>{{ $item->supplier->nama ?? '-' }}</td>
        <td>
            <button class="btn btn-info btn-sm show-btn" data-id="{{ $item->id }}"><i class="fa fa-eye"></i></button>
            <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $item->id }}"><i
                    class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $item->id }}"><i
                    class="fa fa-trash"></i></button>
        </td>
    </tr>
@endforeach
