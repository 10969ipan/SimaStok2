@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <form action="{{ route('backend.penjualan.store') }}" method="post">
            @csrf
            
            {{-- Tampilkan Pesan Error jika stok habis --}}
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white"><i class="fas fa-cash-register"></i> {{ $judul }}</h5>
                    <span class="badge bg-light text-primary">Mode Kasir</span>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4 p-3 bg-light rounded mx-1">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tanggal Transaksi</label>
                            <input type="date" name="tgl_penjualan" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Pelanggan</label>
                            <select name="id_pelanggan" class="form-control select2" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($pelanggan as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pelanggan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Kasir</label>
                            <input type="text" class="form-control bg-white" value="{{ Auth::user()->nama ?? 'Administrator' }}" readonly>
                        </div>
                    </div>

                    <h5 class="text-secondary mb-3 border-bottom pb-2">Keranjang Belanja</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="tabelTransaksi">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th width="35%">Nama Produk</th>
                                    <th width="15%">Ukuran</th> <th width="20%">Harga Satuan</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Subtotal</th>
                                    <th width="5%"><i class="fas fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody id="bodyTransaksi">
                                <tr class="baris-produk">
                                    <td>
                                        <select name="produk_id[]" class="form-control select-produk" onchange="updateHarga(this)" required>
                                            <option value="" data-harga="0">-- Pilih Produk --</option>
                                            @foreach ($produk as $prod)
                                                <option value="{{ $prod->id }}" data-harga="{{ $prod->harga_jual }}">
                                                    {{ $prod->nama_produk }} (Total Stok: {{ $prod->total_stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="ukuran[]" class="form-control" required>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="XXL">XXL</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control harga-satuan bg-light" readonly value="0">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah[]" class="form-control qty-input text-center" value="1" min="1" onchange="hitungSubtotal(this)" onkeyup="hitungSubtotal(this)" required>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control subtotal fw-bold text-end bg-light" readonly value="0">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-row" disabled>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold fs-5 text-uppercase pt-3">Total Pembayaran</td>
                                    <td colspan="2" class="text-end">
                                        <h3 class="text-primary fw-bold mb-0" id="totalBayar">Rp 0</h3>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <button type="button" class="btn btn-success mt-2" id="tambahBaris">
                        <i class="fas fa-plus-circle"></i> Tambah Barang Lain
                    </button>
                </div>

                <div class="card-footer text-end bg-white py-3">
                    <a href="{{ route('backend.penjualan.index') }}" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4" onclick="return confirm('Simpan transaksi ini?')">
                        <i class="fas fa-save"></i> Simpan Transaksi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi Update Harga
        window.updateHarga = function(selectElement) {
            let harga = selectElement.options[selectElement.selectedIndex].getAttribute('data-harga');
            let row = selectElement.closest('tr');
            row.querySelector('.harga-satuan').value = harga;
            hitungSubtotal(row.querySelector('.qty-input'));
        }

        // Fungsi Hitung Subtotal
        window.hitungSubtotal = function(inputQty) {
            let row = inputQty.closest('tr');
            let harga = parseFloat(row.querySelector('.harga-satuan').value) || 0;
            let qty = parseInt(inputQty.value) || 0;
            let subtotal = harga * qty;
            row.querySelector('.subtotal').value = new Intl.NumberFormat('id-ID').format(subtotal);
            hitungTotalKeseluruhan();
        }

        // Hitung Total Akhir
        function hitungTotalKeseluruhan() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(function(el) {
                let nilai = el.value.replace(/\./g, '');
                total += parseInt(nilai) || 0;
            });
            document.getElementById('totalBayar').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        // Tambah Baris Baru
        document.getElementById('tambahBaris').addEventListener('click', function() {
            let tableBody = document.getElementById('bodyTransaksi');
            let firstRow = tableBody.querySelector('.baris-produk');
            let newRow = firstRow.cloneNode(true);

            // Reset nilai
            newRow.querySelector('select.select-produk').value = "";
            newRow.querySelector('select[name="ukuran[]"]').value = "M"; // Default M
            newRow.querySelector('.harga-satuan').value = 0;
            newRow.querySelector('.qty-input').value = 1;
            newRow.querySelector('.subtotal').value = 0;
            
            // Aktifkan tombol hapus
            let btnHapus = newRow.querySelector('.remove-row');
            btnHapus.disabled = false;
            btnHapus.addEventListener('click', function() {
                this.closest('tr').remove();
                hitungTotalKeseluruhan();
            });

            tableBody.appendChild(newRow);
        });
    });
</script>
@endsection