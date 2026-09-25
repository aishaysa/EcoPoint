<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi EcoPoint #{{ $transaksi->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 13px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2d6a4f;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2d6a4f;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 4px 0 0 0;
            color: #666;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            color: #2d6a4f;
            font-weight: bold;
        }
        .total-box {
            text-align: right;
            margin-top: 10px;
            font-size: 15px;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>EcoPoint Indonesia</h1>
        <p>Struk Resmi Bukti Setoran Sampah Daur Ulang</p>
    </div>

    <table>
        <tr>
            <th style="width: 25%;">No. Transaksi</th>
            <td style="width: 25%;">#TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</td>
            <th style="width: 25%;">Tanggal</th>
            <td style="width: 25%;">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <th>Nama Penyetor</th>
            <td>{{ $transaksi->nama_pengirim ?? $transaksi->pelanggan->nama ?? '-' }}</td>
            <th>No. Handphone</th>
            <td>{{ $transaksi->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <th>Metode Setor</th>
            <td>{{ strtoupper($transaksi->metode) }}</td>
            <th>Status</th>
            <td><strong>{{ strtoupper($transaksi->status) }}</strong></td>
        </tr>
        <tr>
            <th>Titik Kumpul</th>
            <td colspan="3">{{ $transaksi->titikKumpul->nama ?? 'Titik Penjemputan Langsung' }}</td>
        </tr>
    </table>

    <h3>Rincian Sampah</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Sampah</th>
                <th>Berat Estimasi (kg)</th>
                <th>Berat Aktual (kg)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi->jenisSampahs as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ number_format($item->pivot->berat_estimasi ?? $transaksi->berat, 2) }} kg</td>
                <td>{{ number_format($item->pivot->berat_aktual ?? $transaksi->berat_aktual, 2) }} kg</td>
            </tr>
            @empty
            <tr>
                <td>1</td>
                <td>Sampah Campuran Daur Ulang</td>
                <td>{{ number_format($transaksi->berat, 2) }} kg</td>
                <td>{{ number_format($transaksi->berat_aktual, 2) }} kg</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-box">
        Total Poin Didapat: <span style="color: #2d6a4f;">{{ number_format($transaksi->poin_didapat ?? 0) }} Poin</span>
    </div>

    <div class="footer">
        <p>Terima kasih telah berkontribusi menjaga kelestarian lingkungan bersama EcoPoint.</p>
        <p>Dokumen ini sah dan dicetak secara otomatis oleh sistem EcoPoint.</p>
    </div>
</body>
</html>