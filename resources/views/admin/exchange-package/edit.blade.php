@extends('layouts.admin')

@section('title', 'Edit Paket Penukaran')
@section('page_title', 'Edit Paket Penukaran')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px; font-weight:700; color:#1f2937; margin:0;">Edit Paket Penukaran</h1>
            <p style="font-size:14px; color:#6b7280; margin:4px 0 0 0;">Ubah detail paket penukaran yang sudah ada</p>
        </div>
        <a href="{{ route('admin.exchange-package.index') }}" 
           style="display:inline-flex; align-items:center; padding:8px 16px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s;">
            <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div style="background:#fef2f2; border:2px solid #fecaca; border-radius:8px; padding:16px; margin-bottom:16px;">
            <div style="display:flex; gap:12px;">
                <svg style="width:20px; height:20px; color:#dc2626; flex-shrink:0; margin-top:2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p style="font-size:14px; font-weight:700; color:#991b1b; margin:0 0 4px 0;">Terdapat kesalahan:</p>
                    <ul style="font-size:14px; color:#b91c1c; margin:0; padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.exchange-package.update', $package->id) }}" method="POST" id="packageForm">
        @csrf
        @method('PUT')

        <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden;">

            {{-- HEADER FORM --}}
            <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Detail Paket</h3>
                <span style="font-size:11px; font-weight:600; color:#6b7280; background:#e5e7eb; padding:4px 10px; border-radius:6px;">
                    ID: #{{ $package->id }}
                </span>
            </div>

            <div style="padding:20px;">

                {{-- JUMLAH POIN --}}
                <div style="margin-bottom:20px;">
                    <label for="points" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Jumlah Poin <span style="color:#dc2626;">*</span>
                    </label>
                    <div style="display:flex; align-items:stretch; width:100%;">
                        <input type="number" name="points" id="points" 
                               value="{{ old('points', $package->points) }}"
                               placeholder="Contoh: 1000"
                               min="1" required
                               style="flex:1 1 auto; min-width:0; padding:12px 16px; border:2px solid #d1d5db; border-right:none; border-radius:8px 0 0 8px; font-size:16px; font-weight:600; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                        <span style="display:flex; align-items:center; padding:0 16px; font-size:12px; font-weight:700; color:#166534; background:#dcfce7; border:2px solid #86efac; border-left:none; border-radius:0 8px 8px 0; white-space:nowrap;">
                            POIN
                        </span>
                    </div>
                </div>

                {{-- JUMLAH UANG --}}
                <div style="margin-bottom:20px;">
                    <label for="amount" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Jumlah Uang <span style="color:#dc2626;">*</span>
                    </label>
                    <div style="display:flex; align-items:stretch; width:100%;">
                        <span style="display:flex; align-items:center; padding:0 16px; font-size:14px; font-weight:700; color:#4b5563; background:#f3f4f6; border:2px solid #d1d5db; border-right:none; border-radius:8px 0 0 8px; white-space:nowrap;">
                            Rp
                        </span>
                        <input type="number" name="amount" id="amount" 
                               value="{{ old('amount', $package->amount) }}"
                               placeholder="Contoh: 10000"
                               min="1" required
                               style="flex:1 1 auto; min-width:0; padding:12px 16px; border:2px solid #d1d5db; border-radius:0 8px 8px 0; font-size:16px; font-weight:600; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                {{-- RATE PREVIEW --}}
                <div style="background:#f0fdf4; border:2px solid #bbf7d0; border-radius:8px; padding:12px 16px; margin-bottom:20px;">
                    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:8px;">
                        <span style="font-size:11px; color:#4b5563; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">Rate Konversi</span>
                        <div style="display:flex; align-items:center; gap:12px; font-size:12px; font-weight:600;">
                            <span style="color:#374151;">1 Poin <span id="ratePerPoint" style="color:#15803d; font-weight:700;">= Rp 0</span></span>
                            <span style="color:#d1d5db;">|</span>
                            <span style="color:#374151;">100 Poin <span id="ratePer100" style="color:#15803d; font-weight:700;">= Rp 0</span></span>
                        </div>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div style="margin-bottom:20px;">
                    <label for="description" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Deskripsi <span style="color:#9ca3af; font-weight:500; text-transform:none;">(Opsional)</span>
                    </label>
                    <input type="text" name="description" id="description" 
                           value="{{ old('description', $package->description) }}"
                           placeholder="Contoh: Paket Hemat, Paket Populer, dll"
                           maxlength="100"
                           style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                </div>

                {{-- STATUS --}}
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Status Paket
                    </label>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <label style="cursor:pointer; display:block; position:relative;">
                            <input type="radio" name="is_active" value="1" 
                                   {{ old('is_active', $package->is_active) == 1 ? 'checked' : '' }}
                                   style="position:absolute; opacity:0; pointer-events:none;">
                            <div class="status-card status-active" style="display:flex; align-items:center; justify-content:center; gap:8px; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; background:#fff; font-size:14px; font-weight:700; color:#4b5563; transition:all 0.2s;">
                                <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Aktif
                            </div>
                        </label>
                        <label style="cursor:pointer; display:block; position:relative;">
                            <input type="radio" name="is_active" value="0" 
                                   {{ old('is_active', $package->is_active) == 0 ? 'checked' : '' }}
                                   style="position:absolute; opacity:0; pointer-events:none;">
                            <div class="status-card status-inactive" style="display:flex; align-items:center; justify-content:center; gap:8px; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; background:#fff; font-size:14px; font-weight:700; color:#4b5563; transition:all 0.2s;">
                                <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Nonaktif
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            {{-- ACTION BUTTONS --}}
            <div style="padding:16px 20px; background:#f9fafb; border-top:2px solid #e5e7eb; display:flex; flex-wrap:wrap; gap:12px; justify-content:flex-end;">
                <a href="{{ route('admin.exchange-package.index') }}" 
                   style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                    Batal
                </a>
                <button type="submit" 
                        style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#2563eb; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer;">
                    <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Paket
                </button>
            </div>

        </div>
    </form>
</div>

<style>
    #points:focus, #amount:focus, #description:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15) !important;
    }

    .status-active {
        border-color: #d1d5db;
        background: #fff;
        color: #4b5563;
    }
    input[value="1"]:checked + .status-active {
        border-color: #16a34a !important;
        background: #f0fdf4 !important;
        color: #15803d !important;
    }

    .status-inactive {
        border-color: #d1d5db;
        background: #fff;
        color: #4b5563;
    }
    input[value="0"]:checked + .status-inactive {
        border-color: #dc2626 !important;
        background: #fef2f2 !important;
        color: #b91c1c !important;
    }

    .status-card:hover {
        border-color: #9ca3af;
    }
</style>

<script>
    (function() {
        const pointsInput = document.getElementById('points');
        const amountInput = document.getElementById('amount');
        const ratePerPoint = document.getElementById('ratePerPoint');
        const ratePer100 = document.getElementById('ratePer100');

        function updateRate() {
            const points = parseFloat(pointsInput.value) || 0;
            const amount = parseFloat(amountInput.value) || 0;

            if (points > 0 && amount > 0) {
                const rate = amount / points;
                ratePerPoint.textContent = '= Rp ' + rate.toLocaleString('id-ID', { maximumFractionDigits: 2 });
                ratePer100.textContent = '= Rp ' + (rate * 100).toLocaleString('id-ID', { maximumFractionDigits: 0 });
            } else {
                ratePerPoint.textContent = '= Rp 0';
                ratePer100.textContent = '= Rp 0';
            }
        }

        [pointsInput, amountInput].forEach(el => {
            el.addEventListener('input', updateRate);
        });

        updateRate();
    })();
</script>
@endsection