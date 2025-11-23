@extends('backend.v_layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">{{ $judul }} #TRX-{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('backend.penjualan.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Penjualan</label>
                                <input type="date" name="tgl_penjualan" class="form-control" value="{{ old('tgl_penjualan', $data->tgl_penjualan) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pelanggan</label>
                                <select name="id_pelanggan" class="form-control select2" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($pelanggan as $p)
                                        <option value="{{ $p->id }}" {{ old('id_pelanggan', $data->id_pelanggan) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_pelanggan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="font-weight-bold">Detail Barang</h6>
                    
                    <table class="table table-bordered" id="tabel-produk">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th width="15%">Ukuran</th>
                                <th width="15%">Qty</th>
                                <th width="10%"><button type="button" class="btn btn-sm btn-success btn-add"><i class="fa fa-plus"></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data akan di-load via JS di bawah --}}
                        </tbody>
                    </table>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Perbaharui Transaksi</button>
                        <a href="{{ route('backend.penjualan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk Dynamic Rows --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Data existing details dari controller
        var existingDetails = @json($data->details);

        // Jika ada data lama (saat edit), loop dan tampilkan
        if(existingDetails.length > 0){
            $.each(existingDetails, function(index, value){
                addRequestItem(value.id_produk, value.ukuran, value.kuantitas);
            });
        } else {
            // Jika kosong (tapi jarang terjadi di edit), tambah 1 baris kosong
            addRequestItem();
        }

        // Fungsi Tambah Baris
        $('.btn-add').click(function() {
            addRequestItem();
        });

        // Fungsi Hapus Baris
        $(document).on('click', '.btn-remove', function() {
            $(this).closest('tr').remove();
        });

        function addRequestItem(selectedProduk = null, selectedUkuran = null, selectedQty = 1) {
            var row = '<tr>';
            
            // Kolom Produk
            row += '<td>';
            row += '<select name="produk_id[]" class="form-control" required>';
            row += '<option value="">-- Pilih Produk --</option>';
            @foreach ($produk as $prod)
                var isSelected = (selectedProduk == "{{ $prod->id }}") ? 'selected' : '';
                row += '<option value="{{ $prod->id }}" '+isSelected+'>{{ $prod->nama_produk }} (Stok Total: {{ $prod->stok_xs+$prod->stok_s+$prod->stok_m+$prod->stok_l+$prod->stok_xl+$prod->stok_xxl }})</option>';
            @endforeach
            row += '</select>';
            row += '</td>';

            // Kolom Ukuran
            var ukuranArr = ['S', 'M', 'L', 'XL', 'XXL']; // Sesuaikan dengan database Anda
            row += '<td>';
            row += '<select name="ukuran[]" class="form-control" required>';
            $.each(ukuranArr, function(i, val){
                var isSelectedSize = (selectedUkuran && selectedUkuran.toUpperCase() == val) ? 'selected' : '';
                row += '<option value="'+val+'" '+isSelectedSize+'>'+val+'</option>';
            });
            row += '</select>';
            row += '</td>';

            // Kolom Qty
            row += '<td><input type="number" name="jumlah[]" class="form-control" min="1" value="'+selectedQty+'" required></td>';
            
            // Tombol Hapus
            row += '<td><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="fa fa-minus"></i></button></td>';
            row += '</tr>';

            $('#tabel-produk tbody').append(row);
        }
    });
</script>
@endsection