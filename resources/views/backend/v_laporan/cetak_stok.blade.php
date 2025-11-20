<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Stok</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .warning { background-color: #ffcccc; } /* Warna merah muda untuk stok tipis */
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>SIMASTOK - TOKO ONLINE</h2>
        <p>Laporan Stok Produk Per {{ date('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Kategori</th>
                <th>Nama Produk</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th class="text-center">Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr class="{{ $row->stok_awal <= 10 ? 'warning' : '' }}">
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $row->kategori }}</td>
                <td>{{ $row->nama_produk }}</td>
                <td class="text-right">Rp {{ number_format($row->harga_beli, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($row->harga_jual, 0, ',', '.') }}</td>
                <td class="text-center">{{ $row->stok_awal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p style="font-size: 10px; margin-top: 5px;">* Baris berwarna merah menandakan stok menipis (<= 10).</p>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak oleh: {{ Auth::user()->nama }}</p>
    </div>

</body>
</html>