@extends('layouts.admin')

@section('title', 'Tambah Jenis Sampah')
@section('page_title', 'Tambah Jenis Sampah')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px; font-weight:700; color:#1f2937; margin:0;">Tambah Jenis Sampah</h1>
            <p style="font-size:14px; color:#6b7280; margin:4px 0 0 0;">Tambahkan jenis sampah baru beserta poin per kg</p>
        </div>
        <a href="{{ route('admin.jenis-sampah.index') }}" 
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

    <form action="{{ route('admin.jenis-sampah.store') }}" method="POST">
        @csrf

        <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden;">

            {{-- HEADER FORM --}}
            <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Detail Jenis Sampah</h3>
            </div>

            <div style="padding:20px;">

                {{-- NAMA --}}
                <div style="margin-bottom:20px;">
                    <label for="nama" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Nama Sampah <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" 
                           value="{{ old('nama') }}"
                           placeholder="Contoh: Botol Plastik, Kertas, Kaca"
                           required
                           class="form-input"
                           style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                </div>

                {{-- POIN PER KG --}}
                <div style="margin-bottom:20px;">
                    <label for="poin_per_kg" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Poin per Kg <span style="color:#dc2626;">*</span>
                    </label>
                    <div style="display:flex; align-items:stretch; width:100%;">
                        <input type="number" id="poin_per_kg" name="poin_per_kg" 
                               value="{{ old('poin_per_kg', 1) }}"
                               placeholder="Contoh: 5"
                               min="0" required
                               class="form-input"
                               style="flex:1 1 auto; min-width:0; padding:12px 16px; border:2px solid #d1d5db; border-right:none; border-radius:8px 0 0 8px; font-size:16px; font-weight:600; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                        <span style="display:flex; align-items:center; padding:0 16px; font-size:12px; font-weight:700; color:#166534; background:#dcfce7; border:2px solid #86efac; border-left:none; border-radius:0 8px 8px 0; white-space:nowrap;">
                            POIN
                        </span>
                    </div>
                    <div style="margin-top:8px; padding:10px 12px; background:#f0fdf4; border:2px solid #bbf7d0; border-radius:8px; display:flex; align-items:flex-start; gap:8px;">
                        <svg style="width:16px; height:16px; color:#15803d; flex-shrink:0; margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p style="font-size:12px; color:#15803d; margin:0; line-height:1.5;">
                            Jumlah poin yang didapat pelanggan per kg sampah ini.
                        </p>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <label for="deskripsi" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Deskripsi <span style="color:#9ca3af; font-weight:500; text-transform:none;">(Opsional)</span>
                    </label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                              placeholder="Deskripsi singkat tentang jenis sampah ini"
                              class="form-input"
                              style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box; resize:vertical; font-family:inherit;">{{ old('deskripsi') }}</textarea>
                </div>

            </div>

            {{-- ACTION BUTTONS --}}
            <div style="padding:16px 20px; background:#f9fafb; border-top:2px solid #e5e7eb; display:flex; flex-wrap:wrap; gap:12px; justify-content:flex-end;">
                <a href="{{ route('admin.jenis-sampah.index') }}"
                   style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                    Batal
                </a>
                <button type="submit"
                        style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer;">
                    <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Jenis Sampah
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
@endsection