<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Stok Bahan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .warning { background-color: #ffcccc; } /* Merah jika stok tipis */
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>SIMASTOK</h2>
        <p>Laporan Stok Bahan Baku Per {{ date('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Nama Bahan</th>
                <th>Supplier</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $row)
            <tr class="{{ $row->stok <= 10 ? 'warning' : '' }}">
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $row->nama_bahan }}</td>
                <td>
                    {{-- Cek apakah supplier ada (mengantisipasi jika supplier dihapus) --}}
                    {{ $row->supplier ? $row->supplier->nama_supplier : '-' }}
                </td>
                <td class="text-center">{{ $row->satuan_unit }}</td>
                <td class="text-center">{{ $row->stok }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Data tidak tersedia</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <p style="font-size: 10px; margin-top: 5px;">* Baris berwarna merah menandakan stok menipis (<= 10).</p>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak oleh: {{ Auth::user()->nama }}</p>
    </div>

</body>
</html>