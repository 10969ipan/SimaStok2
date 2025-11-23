@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <form action="{{ route('backend.penjualan.store') }}" method="post">
            @csrf
            
            {{-- Pesan Error jika stok habis --}}
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white"><i class="fas fa-cash-register"></i> {{ $judul }}</h5>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="fw-bold">Tanggal</label>
                            <input type="date" name="tgl_penjualan" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold">Pelanggan</label>
                            <select name="id_pelanggan" class="form-control select2" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($pelanggan as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pelanggan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold">Kasir</label>
                            <input type="text" class="form-control bg-light" value="{{ Auth::user()->nama ?? 'Admin' }}" readonly>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="tabelTransaksi">
                            <thead class="table-light text-center">
                                <tr>
                                    <th width="35%">Produk</th>
                                    <th width="15%">Ukuran</th>
                                    <th width="20%">Harga Satuan</th>
                                    <th width="10%">Qty</th>
                                    <th width="20%">Subtotal</th>
                                    <th><i class="fas fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody id="bodyTransaksi">
                                {{-- Baris Default --}}
                                <tr class="baris-produk">
                                    <td>
                                        <select name="produk_id[]" class="form-control select-produk" onchange="updateHarga(this)" required>
                                            <option value="" data-harga="0">-- Pilih Produk --</option>
                                            @foreach ($produk as $prod)
                                                {{-- PERBAIKAN: Gunakan 'harga_jual' dan 'total_stok' --}}
                                                <option value="{{ $prod->id }}" data-harga="{{ $prod->harga_jual }}">
                                                    {{ $prod->nama_produk }} (Sisa Stok: {{ $prod->total_stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        {{-- Tambahan: Input Ukuran --}}
                                        <select name="ukuran[]" class="form-control" required>
                                            <option value="S">S</option>
                                            <option value="M" selected>M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control harga-satuan bg-light" readonly value="0">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah[]" class="form-control qty-input text-center" value="1" min="1" onchange="hitungSubtotal(this)" onkeyup="hitungSubtotal(this)">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control subtotal fw-bold text-end bg-light" readonly value="0">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-row" disabled><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold pt-3">TOTAL BAYAR</td>
                                    <td colspan="2">
                                        <h4 class="text-primary fw-bold text-end" id="totalBayar">Rp 0</h4>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <button type="button" class="btn btn-success mt-2" id="tambahBaris"><i class="fas fa-plus-circle"></i> Tambah Produk Lain</button>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    <a href="{{ route('backend.penjualan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Saat produk dipilih, ambil harga dari data-harga
    window.updateHarga = function(el) {
        let harga = el.options[el.selectedIndex].getAttribute('data-harga');
        let row = el.closest('tr');
        row.querySelector('.harga-satuan').value = harga;
        hitungSubtotal(row.querySelector('.qty-input'));
    }

    // 2. Hitung subtotal baris (Harga x Qty)
    window.hitungSubtotal = function(el) {
        let row = el.closest('tr');
        let harga = row.querySelector('.harga-satuan').value || 0;
        let qty = el.value || 0;
        let subtotal = harga * qty;
        
        // Format tampilan Rupiah
        row.querySelector('.subtotal').value = new Intl.NumberFormat('id-ID').format(subtotal);
        hitungTotal();
    }

    // 3. Hitung Total Keseluruhan
    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(el => {
            let val = el.value.replace(/\./g, ''); // Hapus titik ribuan
            total += parseInt(val) || 0;
        });
        document.getElementById('totalBayar').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    // 4. Tombol Tambah Baris
    document.getElementById('tambahBaris').addEventListener('click', function() {
        let row = document.querySelector('.baris-produk').cloneNode(true);
        // Reset nilai di baris baru
        row.querySelector('select.select-produk').value = "";
        row.querySelector('.harga-satuan').value = 0;
        row.querySelector('.qty-input').value = 1;
        row.querySelector('.subtotal').value = 0;
        
        // Aktifkan tombol hapus
        let btn = row.querySelector('.remove-row');
        btn.disabled = false;
        btn.addEventListener('click', function() { this.closest('tr').remove(); hitungTotal(); });
        
        document.getElementById('bodyTransaksi').appendChild(row);
    });
});
</script>
@endsection