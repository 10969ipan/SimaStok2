<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        @media print {
            @page { size: A4; margin: 20mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>SIMASTOK</h2>
        <p>Laporan Transaksi Penjualan</p>
        <p>Periode: {{ \Carbon\Carbon::parse($tgl_awal)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($tgl_akhir)->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Kasir (User)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $row)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tgl_penjualan)->format('d/m/Y') }}</td>
                <td>{{ $row->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                <td>{{ $row->user->nama ?? 'System' }}</td>
                <td>Transaksi Berhasil</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak pada: {{ date('d M Y H:i') }}</p>
        <br><br><br>
        <p>( {{ Auth::user()->nama }} )</p>
    </div>

</body>
</html>