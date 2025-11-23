<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Stok Detail</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .warning { background-color: #ffcccc; } /* Merah jika stok tipis */
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>SIMASTOK</h2>
        <p>Laporan Stok Detail Produk Per {{ date('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                {{-- Kolom Baru untuk Detail --}}
                <th class="text-center">Ukuran</th>
                <th class="text-center">Warna</th>
                <th class="text-center">Stok</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($data as $produk)
                {{-- Cek apakah produk memiliki varian detail --}}
                @if($produk->details->isNotEmpty())
                    @foreach($produk->details as $detail)
                    <tr class="{{ $detail->stok <= 5 ? 'warning' : '' }}">
                        <td class="text-center">{{ $no++ }}</td>
                        <td>
                            {{ $produk->nama_produk }} <br>
                            <small style="color: #666;">SKU: {{ $detail->sku_detail ?? '-' }}</small>
                        </td>
                        <td>{{ $produk->kategori }}</td>
                        
                        {{-- Data dari tabel produk_details --}}
                        <td class="text-center">{{ $detail->ukuran }}</td>
                        <td class="text-center">{{ $detail->warna }}</td>
                        <td class="text-center font-weight-bold">{{ $detail->stok }}</td>
                    </tr>
                    @endforeach
                @else
                    {{-- JIKA TIDAK ADA DETAIL (Produk Simple), TAMPILKAN STOK UTAMA --}}
                    <tr class="{{ $produk->stok_awal <= 10 ? 'warning' : '' }}">
                        <td class="text-center">{{ $no++ }}</td>
                        <td>
                            {{ $produk->nama_produk }} <br>
                            <small style="color: #666;">SKU: {{ $produk->sku_code }}</small>
                        </td>
                        <td>{{ $produk->kategori }}</td>
                        <td class="text-center">-</td>
                        <td class="text-center">{{ $produk->warna ?? '-' }}</td>
                        <td class="text-center">{{ $produk->stok_awal }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    
    <p style="font-size: 10px; margin-top: 5px;">* Baris berwarna merah menandakan stok varian menipis (<= 5).</p>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak oleh: {{ Auth::user()->nama }}</p>
    </div>

</body>
</html>