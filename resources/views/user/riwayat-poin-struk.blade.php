<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Poin</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Courier New', monospace;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            padding: 30px 15px;
        }
        .struk-container {
            max-width: 500px;
            width: 100%;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            padding: 30px 25px 25px;
            border: 1px solid #e6ebf0;
        }
        .struk-header {
            text-align: center;
            border-bottom: 2px dashed #dce1e6;
            padding-bottom: 18px;
            margin-bottom: 20px;
        }
        .struk-header h1 {
            font-size: 22px;
            color: #1f3a4b;
            letter-spacing: 1px;
        }
        .struk-header .sub {
            font-size: 12px;
            color: #6b7a8a;
            margin-top: 4px;
        }
        .struk-header .saldo-box {
            display: inline-block;
            background: #e8f5e9;
            padding: 6px 18px;
            border-radius: 20px;
            font-size: 14px;
            color: #0a6b4a;
            margin-top: 8px;
            font-weight: bold;
        }
        .struk-body {
            margin-bottom: 20px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f3f6;
            font-size: 13px;
        }
        .row:last-child {
            border-bottom: none;
        }
        .row-header {
            font-weight: 700;
            color: #1f3a4b;
            border-bottom: 2px solid #dce1e6;
            padding-bottom: 6px;
            margin-bottom: 4px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .label {
            color: #6b7a8a;
            font-weight: 600;
        }
        .value {
            color: #1f3a4b;
            font-weight: 500;
            text-align: right;
        }
        .value.plus {
            color: #0a6b4a;
        }
        .value.minus {
            color: #b91c1c;
        }
        .divider {
            border-top: 2px dashed #dce1e6;
            margin: 16px 0;
        }
        .footer {
            text-align: center;
            border-top: 2px dashed #dce1e6;
            padding-top: 18px;
            margin-top: 10px;
            font-size: 11px;
            color: #8a9aa8;
        }
        .footer small {
            display: block;
            margin-top: 4px;
        }
        .btn-back {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #eef2f6;
            color: #1f3a4b;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-back:hover {
            background: #dce1e6;
        }
        .btn-print {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background: #0a6b4a;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-print:hover {
            background: #085a3e;
        }
        .empty-state {
            text-align: center;
            padding: 30px 0;
            color: #8a9aa8;
        }
        .empty-state i {
            font-size: 30px;
            margin-bottom: 10px;
            display: block;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .struk-container {
                box-shadow: none;
                border: none;
                border-radius: 0;
                padding: 20px;
            }
            .btn-print, .btn-back {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="struk-container" id="struk">
        <div class="struk-header">
            <h1>EcoPoint</h1>
            <div class="sub">Riwayat Poin</div>
            <div class="saldo-box">
                Saldo Saat Ini: {{ number_format(auth()->user()->points ?? 0) }} Poin
            </div>
        </div>

        <div class="struk-body">
            @if($riwayat->count())
                <div class="row row-header">
                    <span>Tanggal / Aktivitas</span>
                    <span>Jumlah</span>
                </div>

                @foreach($riwayat as $item)
                <div class="row">
                    <span class="label">
                        <div>{{ $item->created_at->format('d M Y') }}</div>
                        <div style="font-weight:normal;font-size:11px;color:#8a9aa8;">{{ $item->jenis_label }}</div>
                        @if($item->deskripsi)
                            <div style="font-weight:normal;font-size:11px;color:#6b7a8a;">{{ $item->deskripsi }}</div>
                        @endif
                        <div style="font-weight:normal;font-size:10px;color:#b0b8c4;">Saldo: {{ number_format($item->saldo_sebelumnya) }} → {{ number_format($item->saldo_setelah) }}</div>
                    </span>
                    <span class="value {{ $item->jumlah > 0 ? 'plus' : 'minus' }}">
                        {{ $item->jumlah > 0 ? '+' : '' }}{{ number_format($item->jumlah) }}
                    </span>
                </div>
                @endforeach

                <div class="divider"></div>

                <div class="row" style="font-weight:700;font-size:15px;padding-top:12px;border-top:2px solid #0a6b4a;margin-top:10px;">
                    <span class="label" style="color:#0a6b4a;">Total Transaksi</span>
                    <span class="value" style="color:#0a6b4a;">{{ $riwayat->count() }} kali</span>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox" style="font-family: 'Font Awesome 6 Free'; font-weight: 900;">📭</i>
                    <p>Belum ada riwayat poin</p>
                    <p style="font-size:12px;margin-top:4px;">Aktivitas setoran atau penarikan Anda akan muncul di sini</p>
                </div>
            @endif
        </div>

        <div class="footer">
            <span>Terima kasih telah berkontribusi menjaga lingkungan</span>
            <small>EcoPoint -- Daur Ulang untuk Lindungi Lingkungan</small>
        </div>

        <button class="btn-print" onclick="window.print()">Cetak / Print</button>
        <a href="{{ route('user.dashboard') }}" class="btn-back">Kembali ke Dashboard</a>
    </div>
</body>
</html>