@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <form action="{{ route('backend.penjualan.store') }}" method="post">
            @csrf
            
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
                                    <th width="40%">Nama Produk</th>
                                    <th width="20%">Harga Satuan</th>
                                    <th width="15%">Jumlah</th>
                                    <th width="20%">Subtotal</th>
                                    <th width="5%"><i class="fas fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody id="bodyTransaksi">
                                <tr class="baris-produk">
                                    <td>
                                        <select name="produk_id[]" class="form-control select-produk" onchange="updateHarga(this)" required>
                                            <option value="" data-harga="0">-- Pilih Produk --</option>
                                            @foreach ($produk as $prod)
                                                <option value="{{ $prod->id }}" data-harga="{{ $prod->harga }}">
                                                    {{ $prod->nama_produk }} (Stok: {{ $prod->stok }})
                                                </option>
                                            @endforeach
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
                                    <td colspan="3" class="text-end fw-bold fs-5 text-uppercase pt-3">Total Pembayaran</td>
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
    // Fungsi dijalankan saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Fungsi Update Harga saat pilih produk
        window.updateHarga = function(selectElement) {
            let harga = selectElement.options[selectElement.selectedIndex].getAttribute('data-harga');
            let row = selectElement.closest('tr');
            
            // Isi input harga
            row.querySelector('.harga-satuan').value = harga;
            
            // Hitung ulang subtotal baris ini
            hitungSubtotal(row.querySelector('.qty-input'));
        }

        // 2. Fungsi Hitung Subtotal per Baris
        window.hitungSubtotal = function(inputQty) {
            let row = inputQty.closest('tr');
            let harga = parseFloat(row.querySelector('.harga-satuan').value) || 0;
            let qty = parseInt(inputQty.value) || 0;
            
            let subtotal = harga * qty;
            
            // Tampilkan subtotal dengan format ribuan
            row.querySelector('.subtotal').value = new Intl.NumberFormat('id-ID').format(subtotal);
            
            hitungTotalKeseluruhan();
        }

        // 3. Fungsi Hitung Total Semua Belanjaan
        function hitungTotalKeseluruhan() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(function(el) {
                // Hapus titik ribuan sebelum dijumlahkan
                let nilai = el.value.replace(/\./g, '');
                total += parseInt(nilai) || 0;
            });
            
            document.getElementById('totalBayar').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        // 4. Logika Tambah Baris Baru
        document.getElementById('tambahBaris').addEventListener('click', function() {
            let tableBody = document.getElementById('bodyTransaksi');
            let firstRow = tableBody.querySelector('.baris-produk'); // Ambil baris pertama sebagai template
            let newRow = firstRow.cloneNode(true); // Duplikat baris

            // Reset nilai input di baris baru
            newRow.querySelector('select').value = "";
            newRow.querySelector('.harga-satuan').value = 0;
            newRow.querySelector('.qty-input').value = 1;
            newRow.querySelector('.subtotal').value = 0;
            
            // Aktifkan tombol hapus di baris baru
            let btnHapus = newRow.querySelector('.remove-row');
            btnHapus.disabled = false;
            
            // Tambahkan event listener untuk hapus baris
            btnHapus.addEventListener('click', function() {
                this.closest('tr').remove();
                hitungTotalKeseluruhan();
            });

            // Masukkan baris baru ke tabel
            tableBody.appendChild(newRow);
        });
    });
</script>

@endsection