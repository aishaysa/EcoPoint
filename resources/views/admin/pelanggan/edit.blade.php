@extends('layouts.admin')

@section('title', 'Edit Pelanggan')
@section('page_title', 'Edit Pelanggan')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px; font-weight:700; color:#1f2937; margin:0;">Edit Pelanggan</h1>
            <p style="font-size:14px; color:#6b7280; margin:4px 0 0 0;">Ubah data pelanggan yang sudah ada</p>
        </div>
        <a href="{{ route('admin.pelanggan.index') }}" 
           style="display:inline-flex; align-items:center; padding:8px 16px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s;">
            <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- ERROR VALIDATION --}}
    @if($errors->any())
        <div style="background:#fef2f2; border:2px solid #fecaca; border-radius:8px; padding:16px; margin-bottom:16px;">
            <div style="display:flex; gap:12px;">
                <svg style="width:20px; height:20px; color:#dc2626; flex-shrink:0; margin-top:2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p style="font-size:14px; font-weight:700; color:#991b1b; margin:0 0 4px 0;">Terdapat kesalahan:</p>
                    <ul style="font-size:14px; color:#b91c1c; margin:0; padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.pelanggan.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden;">

            {{-- HEADER FORM --}}
            <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Data Pelanggan</h3>
                <span style="font-size:11px; font-weight:600; color:#6b7280; background:#e5e7eb; padding:4px 10px; border-radius:6px;">
                    ID: #{{ $pelanggan->id }}
                </span>
            </div>

            <div style="padding:20px;">

                {{-- NAMA --}}
                <div style="margin-bottom:20px;">
                    <label for="nama" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Nama Lengkap <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" 
                           value="{{ old('nama', $pelanggan->nama) }}"
                           placeholder="Contoh: Budi Santoso"
                           required
                           class="form-input"
                           style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                </div>

                {{-- NO HP --}}
                <div style="margin-bottom:20px;">
                    <label for="no_hp" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Nomor HP <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" id="no_hp" name="no_hp" 
                           value="{{ old('no_hp', $pelanggan->no_hp) }}"
                           placeholder="Contoh: 08123456789"
                           required
                           class="form-input"
                           style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                </div>

                {{-- EMAIL --}}
                <div style="margin-bottom:20px;">
                    <label for="email" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Email <span style="color:#9ca3af; font-weight:500; text-transform:none;">(Opsional)</span>
                    </label>
                    <input type="email" id="email" name="email" 
                           value="{{ old('email', $pelanggan->email) }}"
                           placeholder="Contoh: budi@email.com"
                           class="form-input"
                           style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                </div>

                {{-- ALAMAT --}}
                <div>
                    <label for="alamat" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Alamat <span style="color:#9ca3af; font-weight:500; text-transform:none;">(Opsional)</span>
                    </label>
                    <textarea id="alamat" name="alamat" rows="3"
                              placeholder="Contoh: Jl. Sudirman No. 123, Jakarta"
                              class="form-input"
                              style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box; resize:vertical; font-family:inherit;">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                </div>

            </div>

            {{-- ACTION BUTTONS --}}
            <div style="padding:16px 20px; background:#f9fafb; border-top:2px solid #e5e7eb; display:flex; flex-wrap:wrap; gap:12px; justify-content:flex-end;">
                <a href="{{ route('admin.pelanggan.index') }}"
                   style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                    Batal
                </a>
                <button type="submit"
                        style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#2563eb; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer;">
                    <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Pelanggan
                </button>
            </div>

        </div>
    </form>
</div>

{{-- FOCUS STYLE --}}
<style>
    .form-input:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15) !important;
    }
</style>

{{-- TOAST SUKSES --}}
@if(session('success'))
<div id="toast" style="position:fixed; top:24px; right:24px; z-index:9999; max-width:380px; width:100%; transform:translateX(0); opacity:1; transition:transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;">
    <div style="background:#fff; border-radius:16px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); border:2px solid #bbf7d0; overflow:hidden; position:relative;">
        <div id="toastProgress" style="height:4px; background:linear-gradient(to right, #4ade80, #16a34a); transition:width 10ms linear; width:100%;"></div>
        <div style="padding:20px; display:flex; align-items:flex-start; gap:16px;">
            <div style="flex-shrink:0; width:48px; height:48px; background:linear-gradient(135deg, #4ade80, #16a34a); border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(22,163,74,0.3);">
                <svg style="width:28px; height:28px; color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div style="flex:1; padding-top:2px;">
                <p style="font-size:14px; font-weight:700; color:#1f2937; margin:0 0 4px 0;">Berhasil!</p>
                <p style="font-size:14px; color:#4b5563; margin:0; line-height:1.5;">{{ session('success') }}</p>
            </div>
            <button onclick="closeToast()" style="flex-shrink:0; margin-top:4px; background:none; border:none; cursor:pointer; color:#9ca3af; padding:0;">
                <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif

<script>
    @if(session('success'))
    let progressWidth = 100;
    const progressInterval = setInterval(function() {
        progressWidth -= 0.25;
        const progressBar = document.getElementById('toastProgress');
        if (progressBar) {
            progressBar.style.width = Math.max(progressWidth, 0) + '%';
        }
        if (progressWidth <= 0) {
            clearInterval(progressInterval);
            closeToast();
        }
    }, 10);

    function closeToast() {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.style.transform = 'translateX(calc(100% + 2rem))';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 700);
        }
        clearInterval(progressInterval);
    }

    document.addEventListener('click', function(e) {
        const toast = document.getElementById('toast');
        if (toast && !toast.contains(e.target)) {
            closeToast();
        }
    });
    @endif
</script>
@endsection