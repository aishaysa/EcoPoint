<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Riwayat Poin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            padding: 30px 15px;
        }
        .struk-container {
            max-width: 400px;
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
        .struk-header .id-badge {
            display: inline-block;
            background: #eef2f6;
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 13px;
            color: #1f3a4b;
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
            font-size: 14px;
        }
        .row:last-child {
            border-bottom: none;
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
        .total-row {
            font-size: 17px;
            font-weight: 700;
            color: #0a6b4a;
            padding: 12px 0;
            border-top: 2px solid #0a6b4a;
            margin-top: 10px;
        }
        .total-row .label {
            color: #0a6b4a;
        }
        .total-row .value {
            color: #0a6b4a;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-setoran {
            background: #d1fae5;
            color: #065f46;
        }
        .status-penarikan {
            background: #fee2e2;
            color: #991b1b;
        }
        .status-refund {
            background: #fef3c7;
            color: #b45309;
        }
        .struk-footer {
            text-align: center;
            border-top: 2px dashed #dce1e6;
            padding-top: 18px;
            margin-top: 10px;
            font-size: 11px;
            color: #8a9aa8;
        }
        .struk-footer small {
            display: block;
            margin-top: 4px;
        }
        .btn-print {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 20px;
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
        .btn-back {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 10px;
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
            <div class="sub">Detail Riwayat Poin</div>
            <div class="id-badge">#{{ $riwayat->id }}</div>
        </div>

        <div class="struk-body">
            <div class="row">
                <span class="label">Tanggal</span>
                <span class="value">{{ $riwayat->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="row">
                <span class="label">User</span>
                <span class="value">{{ auth()->user()->name }}</span>
            </div>
            <div class="row">
                <span class="label">Jenis Transaksi</span>
                <span class="value">{{ $riwayat->jenis_label }}</span>
            </div>

            <div class="divider"></div>

            <div class="row">
                <span class="label">Deskripsi</span>
                <span class="value" style="text-align:right; max-width:60%;">{{ $riwayat->deskripsi ?? '-' }}</span>
            </div>

            <div class="row">
                <span class="label">Jumlah Poin</span>
                <span class="value {{ $riwayat->jumlah > 0 ? 'plus' : 'minus' }}">
                    {{ $riwayat->jumlah > 0 ? '+' : '' }}{{ number_format($riwayat->jumlah) }}
                </span>
            </div>

            <div class="row">
                <span class="label">Saldo Sebelumnya</span>
                <span class="value">{{ number_format($riwayat->saldo_sebelumnya) }}</span>
            </div>

            <div class="row">
                <span class="label">Saldo Setelah</span>
                <span class="value">{{ number_format($riwayat->saldo_setelah) }}</span>
            </div>

            <div class="divider"></div>

            <div class="row" style="margin-top:8px;">
                <span class="label">Status</span>
                <span class="value">
                    <span class="status-badge status-{{ $riwayat->jenis }}">
                        {{ $riwayat->jenis_label }}
                    </span>
                </span>
            </div>

            @if($riwayat->referensi_type)
            <div class="row">
                <span class="label">Referensi</span>
                <span class="value" style="font-size:12px; color:#8a9aa8;">#{{ $riwayat->referensi_id }}</span>
            </div>
            @endif

            <div class="row total-row">
                <span class="label">Saldo Akhir</span>
                <span class="value">{{ number_format($riwayat->saldo_setelah) }} poin</span>
            </div>
        </div>

        <div class="struk-footer">
            <span>Terima kasih telah berkontribusi menjaga lingkungan</span>
            <small>EcoPoint -- Daur Ulang untuk Lindungi Lingkungan</small>
        </div>

        <button class="btn-print" onclick="window.print()">Cetak / Print</button>
        <a href="{{ route('user.poin') }}" class="btn-back">Kembali ke Riwayat</a>
    </div>
</body>
</html>