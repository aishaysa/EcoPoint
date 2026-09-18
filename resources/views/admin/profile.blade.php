@extends('layouts.admin')

@section('title', 'Profil Admin')
@section('page_title', 'Profil Admin')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px; font-weight:700; color:#1f2937; margin:0;">Profil Admin</h1>
            <p style="font-size:14px; color:#6b7280; margin:4px 0 0 0;">Kelola informasi akun Anda di sini</p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           style="display:inline-flex; align-items:center; padding:10px 20px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
            <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div style="background:#f0fdf4; border:2px solid #bbf7d0; border-radius:8px; padding:14px 16px; margin-bottom:16px; display:flex; align-items:center; gap:10px;">
            <svg style="width:20px; height:20px; color:#15803d; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p style="font-size:14px; font-weight:600; color:#15803d; margin:0;">{{ session('success') }}</p>
        </div>
    @endif

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

    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden;">

            {{-- HEADER FORM --}}
            <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Informasi Akun</h3>
            </div>

            <div style="padding:20px;">

                {{-- AVATAR --}}
                <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px; padding:16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name ?? 'Admin') }}&background=2d6a4f&color=fff&size=128"
                         alt="Avatar"
                         style="width:72px; height:72px; border-radius:50%; border:3px solid #fff; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    <div>
                        <p style="font-size:18px; font-weight:700; color:#1f2937; margin:0 0 4px 0;">{{ $admin->name ?? 'Admin' }}</p>
                        <p style="font-size:13px; color:#6b7280; margin:0;">{{ $admin->email ?? '-' }}</p>
                    </div>
                </div>

                {{-- NAMA --}}
                <div style="margin-bottom:20px;">
                    <label for="name" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Nama Lengkap <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $admin->name) }}"
                           required
                           class="form-input"
                           style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                </div>

                {{-- EMAIL --}}
                <div style="margin-bottom:20px;">
                    <label for="email" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Email <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $admin->email) }}"
                           required
                           class="form-input"
                           style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                </div>

                {{-- PEMISAH --}}
                <div style="border-top:2px solid #f1f5f9; margin:24px 0; padding-top:20px;">
                    <p style="font-size:12px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 16px 0;">
                        Ganti Password (Kosongkan jika tidak diganti)
                    </p>

                    {{-- PASSWORD BARU --}}
                    <div style="margin-bottom:20px;">
                        <label for="password" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                            Password Baru
                        </label>
                        <input type="password" id="password" name="password"
                               placeholder="Minimal 6 karakter"
                               class="form-input"
                               style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                    </div>

                    {{-- KONFIRMASI PASSWORD --}}
                    <div>
                        <label for="password_confirmation" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                            Konfirmasi Password
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               placeholder="Ulangi password baru"
                               class="form-input"
                               style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                    </div>
                </div>

            </div>

            {{-- ACTION BUTTONS --}}
            <div style="padding:16px 20px; background:#f9fafb; border-top:2px solid #e5e7eb; display:flex; flex-wrap:wrap; gap:12px; justify-content:flex-end;">
                <a href="{{ route('admin.dashboard') }}"
                   style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                    Batal
                </a>
                <button type="submit"
                        style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer;">
                    <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </form>
</div>

<style>
    .form-input:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15) !important;
    }
</style>
@endsection