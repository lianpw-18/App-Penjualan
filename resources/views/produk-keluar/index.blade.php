@extends('layouts.app')

{{-- PINDAHKAN @include KE ATAS --}}
@include('produk-keluar.create')

@section('content')
    <style>
        .text-on-left {
            text-align: left !important;
            float: left !important;
            width: 100% !important;
        }
    </style>

    <div class="section-header">
        <h1>Daftar Produk Keluar</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary mx-2" id="button_tambah_barangKeluar">
                <i class="fa fa-plus"></i> Tambah Produk Keluar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card card-primary">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                   <th>Supplier</th> 
                                    <th>Nama Produk</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Stok Keluar</th>
                                    <th>Total Harga</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Datatables Jquery -->
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();

            // Load data produk keluar
            loadDataProdukKeluar();

            function loadDataProdukKeluar() {
    $.ajax({
        url: '/produk-keluar/get-data',
        type: "GET",
        dataType: 'JSON',
        success: function(response) {
            // DEBUG: LIHAT RESPONSE DI CONSOLE
            console.log('Full Response:', response);
            console.log('Response Data:', response.data);
            if (response.debug) {
                console.log('Debug Info:', response.debug);
            }
            
            let counter = 1;
            let table = $('#table_id').DataTable();
            table.clear();
            
            if (response.data && Array.isArray(response.data)) {
                $.each(response.data, function(key, value) {
                    // DEBUG: LIHAT SETIAP RECORD
                    console.log('Record ' + key + ':', value);
                    console.log('Supplier data:', value.supplier);
                    console.log('Supplier name:', value.supplier_name);
                    
                    let aksiBtn = `
                        <button class="btn btn-danger btn-sm btn-delete" data-id="${value.id}">
                            <i class="fa fa-trash"></i>
                        </button>
                    `;
                    
                    // PAKAI SUPPLIER_NAME YANG SUDAH DISET DI CONTROLLER
                    let supplierName = value.supplier_name || 'No Supplier';
                    
                    let produkKeluar = `
                        <tr class="barang-row" id="index_${value.id}">
                            <td>${counter++}</td>   
                            <td>${value.kd_transaksi}</td>
                            <td>${supplierName}</td>
                            <td>${value.nm_produk}</td>
                            <td>${value.tgl_keluar}</td>
                            <td>${value.stok_keluar}</td>
                            <td>Rp ${value.total_harga ? Number(value.total_harga).toLocaleString('id-ID') : '0'}</td>
                            <td>${value.deskripsi}</td>
                            <td>${aksiBtn}</td>
                        </tr>
                    `;
                    table.row.add($(produkKeluar));
                });
            } else {
                console.log('No data or data is not array');
            }
            table.draw();
        },
        error: function(xhr, status, error) {
            console.log('AJAX Error:', error);
            console.log('XHR:', xhr);
            console.log('Status:', status);
        }
    });
}

            // Delete event - SAMA SEPERTI PRODUK MASUK
            $('#table_id').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                if(confirm('Yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: `/produk-keluar/${id}`,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            if(res.success) {
                                loadDataProdukKeluar(); // Reload data
                                Swal.fire('Berhasil!', res.message, 'success');
                            }
                        }
                    });
                }
            });

            // Expose function globally untuk dipanggil dari script lain
            window.loadDataProdukKeluar = loadDataProdukKeluar;
        });
    </script>

    <!-- Generate Tanggal Hari Ini -->
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                var today = new Date();
                var year = today.getFullYear();
                var month = (today.getMonth() + 1).toString().padStart(2, '0');
                var day = today.getDate().toString().padStart(2, '0');
                var formattedDate = year + '-' + month + '-' + day;
                
                if ($('#tgl_keluar').length) {
                    $('#tgl_keluar').val(formattedDate);
                }
            }, 500);
        });
    </script>

    <!-- Show Modal Tambah & Event Handlers -->
    <script>
        // Show Modal - SAMA SEPERTI PRODUK MASUK
        $('body').on('click', '#button_tambah_barangKeluar', function() {
            $('#modal_tambah_barangKeluar').modal('show');
            clearAlert();
            clearForm();
            setTodayDate();
        });

        function clearAlert() {
            $('.alert-danger').addClass('d-none').removeClass('d-block');
        }

        function clearForm() {
            $('#supplier_id').val('');
            $('#nm_produk').empty().append('<option value="">Pilih Supplier terlebih dahulu</option>');
            $('#stok_keluar').val('');
            $('#stok_tersedia').val('');
            $('#deskripsi').val('');
        }

        function setTodayDate() {
            var today = new Date();
            var year = today.getFullYear();
            var month = (today.getMonth() + 1).toString().padStart(2, '0');
            var day = today.getDate().toString().padStart(2, '0');
            var formattedDate = year + '-' + month + '-' + day;
            if ($('#tgl_keluar').length) {
                $('#tgl_keluar').val(formattedDate);
            }
        }

        // Load produk berdasarkan supplier
        $(document).on('change', '#supplier_id', function() {
            let supplierId = $(this).val();
            $('#nm_produk').empty();
            $('#stok_tersedia').val('');

            if(supplierId) {
                $('#nm_produk').append('<option value="">Loading...</option>');
                $.ajax({
                    url: '/produk-keluar/get-produk-by-supplier',
                    type: 'GET',
                    data: { supplier_id: supplierId },
                    success: function(response) {
                        $('#nm_produk').empty().append('<option value="">Pilih Produk</option>');
                        if(response.success && response.data.length > 0) {
                            $.each(response.data, function(key, value) {
                                if(value.stok > 0) {
                                    $('#nm_produk').append(`<option value="${value.nm_barang}">${value.nm_barang} (Stok: ${value.stok})</option>`);
                                }
                            });
                        } else {
                            $('#nm_produk').append('<option value="">Tidak ada produk tersedia</option>');
                        }
                    },
                    error: function() {
                        $('#nm_produk').empty().append('<option value="">Error loading data</option>');
                    }
                });
            } else {
                $('#nm_produk').append('<option value="">Pilih Supplier terlebih dahulu</option>');
            }
        });

        // Load detail produk
        $(document).on('change', '#nm_produk', function() {
            let nmProduk = $(this).val();
            
            if(nmProduk) {
                $.ajax({
                    url: '/produk-keluar/get-produk-detail',
                    type: 'GET',
                    data: { nm_produk: nmProduk },
                    success: function(response) {
                        if(response.success) {
                            $('#stok_tersedia').val(response.stok);
                        }
                    }
                });
            } else {
                $('#stok_tersedia').val('');
            }
        });

        // Store Data - MIRIP DENGAN PRODUK MASUK
        $('#store').click(function(e) {
            e.preventDefault();
            
            let supplier_id = $('#supplier_id').val();
            let nm_produk = $('#nm_produk').val();
            let stok_keluar = $('#stok_keluar').val();
            let deskripsi = $('#deskripsi').val();
            let token = $("meta[name='csrf-token']").attr("content");

            // Validasi sederhana
            if (!supplier_id) {
                alert('Pilih supplier terlebih dahulu');
                return;
            }
            if (!nm_produk) {
                alert('Pilih produk');
                return;
            }
            if (!stok_keluar || stok_keluar <= 0) {
                alert('Masukkan stok keluar yang valid');
                return;
            }
            if (!deskripsi) {
                alert('Masukkan deskripsi');
                return;
            }

            // Disable button saat proses
            $('#store').prop('disabled', true).text('Menyimpan...');

            $.ajax({
                url: '/produk-keluar',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {
                    supplier_id: supplier_id,
                    nm_produk: nm_produk,
                    stok_keluar: stok_keluar,
                    deskripsi: deskripsi,
                    _token: token
                },
                success: function(response) {
                    console.log('Success response:', response);
                    
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: response.message || 'Data berhasil disimpan',
                        showConfirmButton: true,
                        timer: 3000
                    });

                    // Reset form dan tutup modal
                    clearForm();
                    $('#modal_tambah_barangKeluar').modal('hide');
                    
                    // Reload data table
                    if (typeof window.loadDataProdukKeluar === 'function') {
                        window.loadDataProdukKeluar();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error response:', xhr.responseJSON);
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Laravel validation errors
                        Object.keys(xhr.responseJSON.errors).forEach(function(key) {
                            if (xhr.responseJSON.errors[key] && xhr.responseJSON.errors[key][0]) {
                                let alertId = key.replace('_', '-');
                                $(`#alert-${alertId}`).removeClass('d-none').addClass('d-block');
                                $(`#alert-${alertId}`).html(xhr.responseJSON.errors[key][0]);
                            }
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        alert('Error: ' + xhr.responseJSON.message);
                    } else {
                        alert('Terjadi kesalahan: ' + error);
                    }
                },
                complete: function() {
                    // Re-enable button
                    $('#store').prop('disabled', false).text('Simpan');
                }
            });
        });

        // Reset form saat modal ditutup
        $('#modal_tambah_barangKeluar').on('hidden.bs.modal', function () {
            clearForm();
            clearAlert();
        });
    </script>
@endsection 