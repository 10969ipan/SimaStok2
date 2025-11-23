<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .warning { background-color: #ffcccc; } /* Merah muda jika stok tipis */
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>SIMASTOK</h2>
        <p>Laporan Stok Produk Per {{ date('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">SKU</th>
                <th>Nama Produk</th>
                <th width="20%">Kategori</th>
                <th width="10%">Warna</th>
                <th width="10%">Stok</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($data as $produk)
            {{-- Menandai baris merah jika stok_awal kurang dari atau sama dengan 5 --}}
            <tr class="{{ $produk->stok_awal <= 5 ? 'warning' : '' }}">
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $produk->sku_code }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td>{{ $produk->kategori }}</td>
                <td class="text-center">{{ $produk->warna ?? '-' }}</td>
                <td class="text-center font-weight-bold">{{ $produk->stok_awal }}</td>
            </tr>
            @endforeach
            
            @if($data->isEmpty())
            <tr>
                <td colspan="6" class="text-center">Data produk kosong.</td>
            </tr>
            @endif
        </tbody>
    </table>
    
    <div style="margin-top: 10px; font-size: 11px;">
        <span style="background-color: #ffcccc; border: 1px solid #000; padding: 0 10px;">&nbsp;</span>
        Menandakan stok menipis (<= 5).
    </div>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak oleh: {{ Auth::user()->nama ?? 'Admin' }}</p>
        <br><br>
        <p>(_______________________)</p>
        <p>{{ Auth::user()->nama ?? 'Admin' }}</p>
    </div>

</body>
</html>