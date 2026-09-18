@extends('layouts.admin')

@section('title', 'Data Pelanggan')
@section('page_title', 'Data Pelanggan')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px; font-weight:700; color:#1f2937; margin:0;">Data Pelanggan</h1>
            <p style="font-size:14px; color:#6b7280; margin:4px 0 0 0;">Daftar semua pelanggan terdaftar beserta aktivitas setoran</p>
        </div>
    </div>

    {{-- SEARCH & FILTER --}}
    <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden; margin-bottom:16px;">
        <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb;">
            <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Pencarian</h3>
        </div>
        <form method="GET" action="{{ route('admin.pelanggan.index') }}" style="padding:16px 20px;">
            <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
                <div style="flex:1 1 300px; min-width:0;">
                    <input type="text" name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama, no HP, atau email..."
                           autocomplete="off"
                           class="form-input"
                           style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                </div>
                <button type="submit"
                        style="display:inline-flex; align-items:center; padding:12px 24px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer;">
                    <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.pelanggan.index') }}"
                       style="display:inline-flex; align-items:center; padding:12px 24px; background:#fff; color:#dc2626; border:2px solid #fecaca; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                        <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset
                    </a>
                @endif
            </div>
            @if(request('search'))
                <div style="margin-top:12px; padding-top:12px; border-top:1px solid #f1f5f9; display:flex; align-items:center; gap:8px;">
                    <span style="font-size:12px; color:#6b7280; font-weight:600;">Filter aktif:</span>
                    <span style="display:inline-flex; align-items:center; padding:4px 12px; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; border-radius:20px; font-size:12px; font-weight:700;">
                        "{{ request('search') }}"
                    </span>
                </div>
            @endif
        </form>
    </div>

    {{-- INFO PAGINATION ATAS --}}
    <div style="margin-bottom:16px; padding:12px 16px; background:#fff; border-radius:8px; border:2px solid #e5e7eb; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px;">
        <div style="font-size:13px; color:#6b7280;">
            Menampilkan <span style="font-weight:700; color:#1f2937;">{{ $pelanggans->firstItem() ?? 0 }}</span> 
            - <span style="font-weight:700; color:#1f2937;">{{ $pelanggans->lastItem() ?? 0 }}</span> 
            dari <span style="font-weight:700; color:#1f2937;">{{ $pelanggans->total() }}</span> data
        </div>

        <nav style="display:flex; align-items:center; gap:4px;">
            @if ($pelanggans->onFirstPage())
                <span style="padding:6px 12px; border:2px solid #e5e7eb; border-radius:6px; font-size:13px; background:#f9fafb; color:#9ca3af; cursor:not-allowed;">‹ Sebelumnya</span>
            @else
                <a href="{{ $pelanggans->appends(request()->query())->previousPageUrl() }}" 
                   style="padding:6px 12px; border:2px solid #d1d5db; border-radius:6px; font-size:13px; background:#fff; color:#374151; text-decoration:none; font-weight:600;">
                    ‹ Sebelumnya
                </a>
            @endif

            @foreach ($pelanggans->appends(request()->query())->links()->elements[0] ?? [] as $page => $url)
                @if ($page == $pelanggans->currentPage())
                    <span style="padding:6px 12px; border:2px solid #16a34a; border-radius:6px; font-size:13px; font-weight:700; background:#16a34a; color:#fff;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" 
                       style="padding:6px 12px; border:2px solid #d1d5db; border-radius:6px; font-size:13px; background:#fff; color:#374151; text-decoration:none; font-weight:600;">{{ $page }}</a>
                @endif
            @endforeach

            @if (!count($pelanggans->appends(request()->query())->links()->elements[0] ?? []))
                <span style="padding:6px 12px; border:2px solid #16a34a; border-radius:6px; font-size:13px; font-weight:700; background:#16a34a; color:#fff;">1</span>
            @endif

            @if ($pelanggans->hasMorePages())
                <a href="{{ $pelanggans->appends(request()->query())->nextPageUrl() }}" 
                   style="padding:6px 12px; border:2px solid #d1d5db; border-radius:6px; font-size:13px; background:#fff; color:#374151; text-decoration:none; font-weight:600;">
                    Selanjutnya ›
                </a>
            @else
                <span style="padding:6px 12px; border:2px solid #e5e7eb; border-radius:6px; font-size:13px; background:#f9fafb; color:#9ca3af; cursor:not-allowed;">Selanjutnya ›</span>
            @endif
        </nav>
    </div>

    {{-- TABEL --}}
    <div style="overflow-x:auto; background:#fff; border-radius:8px; border:2px solid #e5e7eb;">
        <table style="min-width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="background:#f9fafb;">
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">No</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">Nama</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">No HP</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">Alamat</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">Poin</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">Total Setoran</th>
                    <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggans as $key => $p)
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:14px 16px; color:#4b5563; font-weight:600;">{{ $pelanggans->firstItem() + $key }}</td>
                    <td style="padding:14px 16px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:36px; height:36px; border-radius:50%; background:#dcfce7; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <span style="font-size:13px; font-weight:700; color:#15803d;">{{ strtoupper(substr($p->nama, 0, 1)) }}</span>
                            </div>
                            <span style="font-size:13px; font-weight:700; color:#1f2937;">{{ $p->nama }}</span>
                        </div>
                    </td>
                    <td style="padding:14px 16px; color:#4b5563;">
                        @if($p->no_hp)
                            <a href="tel:{{ $p->no_hp }}" style="color:#16a34a; text-decoration:none; font-weight:600;">{{ $p->no_hp }}</a>
                        @else
                            <span style="color:#9ca3af; font-style:italic;">-</span>
                        @endif
                    </td>
                    <td style="padding:14px 16px; color:#4b5563; max-width:240px;">
                        <span style="display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $p->alamat ?? '-' }}
                        </span>
                    </td>
                    <td style="padding:14px 16px;">
                        <span style="display:inline-flex; align-items:center; padding:4px 12px; background:#dcfce7; color:#15803d; border-radius:20px; font-size:12px; font-weight:700;">
                            {{ number_format($p->poin ?? 0) }}
                        </span>
                    </td>
                    <td style="padding:14px 16px; color:#4b5563; font-weight:600;">
                        {{ $p->setorans_count ?? 0 }}
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('admin.pelanggan.show', $p->id) }}" 
                               style="display:inline-flex; align-items:center; padding:6px 12px; background:#dbeafe; color:#1d4ed8; border-radius:6px; text-decoration:none; font-size:12px; font-weight:700;">
                                <svg style="width:14px; height:14px; margin-right:4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>

                            <form action="{{ route('admin.pelanggan.destroy', $p->id) }}" 
                                  method="POST" 
                                  id="delete-form-{{ $p->id }}" 
                                  style="display:inline; margin:0;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button type="button" 
                                    class="delete-btn"
                                    data-nama="{{ $p->nama }}"
                                    data-form-id="delete-form-{{ $p->id }}"
                                    style="display:inline-flex; align-items:center; padding:6px 12px; background:#fee2e2; color:#b91c1c; border:none; border-radius:6px; cursor:pointer; font-size:12px; font-weight:700;">
                                <svg style="width:14px; height:14px; margin-right:4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:60px 20px; text-align:center;">
                        <svg style="width:56px; height:56px; margin:0 auto 12px; color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p style="font-size:15px; font-weight:700; color:#6b7280; margin:0;">
                            @if(request('search'))
                                Tidak ada pelanggan yang cocok dengan pencarian
                            @else
                                Belum ada pelanggan
                            @endif
                        </p>
                        <p style="font-size:13px; color:#9ca3af; margin:4px 0 0 0;">
                            @if(request('search'))
                                Coba kata kunci lain atau reset filter.
                            @else
                                Data pelanggan akan muncul di sini.
                            @endif
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- INFO PAGINATION BAWAH --}}
    <div style="margin-top:16px; padding:12px 16px; background:#fff; border-radius:8px; border:2px solid #e5e7eb; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px;">
        <div style="font-size:13px; color:#6b7280;">
            Menampilkan <span style="font-weight:700; color:#1f2937;">{{ $pelanggans->firstItem() ?? 0 }}</span> 
            - <span style="font-weight:700; color:#1f2937;">{{ $pelanggans->lastItem() ?? 0 }}</span> 
            dari <span style="font-weight:700; color:#1f2937;">{{ $pelanggans->total() }}</span> data
        </div>

        <nav style="display:flex; align-items:center; gap:4px;">
            @if ($pelanggans->onFirstPage())
                <span style="padding:6px 12px; border:2px solid #e5e7eb; border-radius:6px; font-size:13px; background:#f9fafb; color:#9ca3af; cursor:not-allowed;">‹ Sebelumnya</span>
            @else
                <a href="{{ $pelanggans->appends(request()->query())->previousPageUrl() }}" 
                   style="padding:6px 12px; border:2px solid #d1d5db; border-radius:6px; font-size:13px; background:#fff; color:#374151; text-decoration:none; font-weight:600;">
                    ‹ Sebelumnya
                </a>
            @endif

            @foreach ($pelanggans->appends(request()->query())->links()->elements[0] ?? [] as $page => $url)
                @if ($page == $pelanggans->currentPage())
                    <span style="padding:6px 12px; border:2px solid #16a34a; border-radius:6px; font-size:13px; font-weight:700; background:#16a34a; color:#fff;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" 
                       style="padding:6px 12px; border:2px solid #d1d5db; border-radius:6px; font-size:13px; background:#fff; color:#374151; text-decoration:none; font-weight:600;">{{ $page }}</a>
                @endif
            @endforeach

            @if (!count($pelanggans->appends(request()->query())->links()->elements[0] ?? []))
                <span style="padding:6px 12px; border:2px solid #16a34a; border-radius:6px; font-size:13px; font-weight:700; background:#16a34a; color:#fff;">1</span>
            @endif

            @if ($pelanggans->hasMorePages())
                <a href="{{ $pelanggans->appends(request()->query())->nextPageUrl() }}" 
                   style="padding:6px 12px; border:2px solid #d1d5db; border-radius:6px; font-size:13px; background:#fff; color:#374151; text-decoration:none; font-weight:600;">
                    Selanjutnya ›
                </a>
            @else
                <span style="padding:6px 12px; border:2px solid #e5e7eb; border-radius:6px; font-size:13px; background:#f9fafb; color:#9ca3af; cursor:not-allowed;">Selanjutnya ›</span>
            @endif
        </nav>
    </div>

</div>

{{-- FOCUS STYLE --}}
<style>
    .form-input:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15) !important;
    }
    tbody tr:hover {
        background: #f8fafc;
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

{{-- CANCEL TOAST CONTAINER --}}
<div id="cancelToastContainer"></div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="deleteModal" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); align-items:center; justify-content:center; padding:16px;">
    <div id="deleteModalContent" style="background:#fff; border-radius:16px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.3); max-width:420px; width:100%; transform:scale(0.95); opacity:0; transition:all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); padding:24px;">

        <div style="width:64px; height:64px; margin:0 auto 16px; background:#fee2e2; border-radius:50%; display:flex; align-items:center; justify-content:center;">
            <svg style="width:32px; height:32px; color:#dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>

        <h3 style="font-size:18px; font-weight:800; color:#1f2937; text-align:center; margin:0 0 8px 0;">Hapus Pelanggan?</h3>
        <p style="font-size:14px; color:#6b7280; text-align:center; margin:0 0 24px 0; line-height:1.6;">
            Apakah Anda yakin ingin menghapus pelanggan<br>
            <strong id="modalNama" style="color:#1f2937;"></strong>?<br>
            <span style="color:#dc2626; font-weight:600;">Tindakan ini tidak dapat dibatalkan.</span>
        </p>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
            <button type="button" id="modalCancelBtn"
                    style="padding:12px 20px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer;">
                Batal
            </button>
            <button type="button" id="modalConfirmBtn"
                    style="padding:12px 20px; background:#dc2626; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    // TOAST SUKSES
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
            setTimeout(function() { toast.remove(); }, 700);
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

    // TOAST BATAL
    function showCancelToast(message) {
        const container = document.getElementById('cancelToastContainer');
        container.innerHTML = '';
        const toast = document.createElement('div');
        toast.id = 'cancelToast';
        toast.style.cssText = 'position:fixed; top:24px; right:24px; z-index:9999; max-width:380px; width:100%; transform:translateX(0); opacity:1; transition:transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;';
        toast.innerHTML = `
            <div style="background:#fff; border-radius:16px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); border:2px solid #fde68a; overflow:hidden;">
                <div style="padding:20px; display:flex; align-items:flex-start; gap:16px;">
                    <div style="flex-shrink:0; width:48px; height:48px; background:linear-gradient(135deg, #fbbf24, #d97706); border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(217,119,6,0.3);">
                        <svg style="width:28px; height:28px; color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div style="flex:1; padding-top:2px;">
                        <p style="font-size:14px; font-weight:700; color:#1f2937; margin:0 0 4px 0;">Dibatalkan</p>
                        <p style="font-size:14px; color:#4b5563; margin:0; line-height:1.5;">${message}</p>
                    </div>
                    <button onclick="this.closest('#cancelToast').remove()" style="flex-shrink:0; margin-top:4px; background:none; border:none; cursor:pointer; color:#9ca3af; padding:0;">
                        <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(toast);

        setTimeout(() => {
            const el = document.getElementById('cancelToast');
            if (el) {
                el.style.transform = 'translateX(calc(100% + 2rem))';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 700);
            }
        }, 2500);
    }

    // MODAL KONFIRMASI HAPUS
    (function() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        const modalNama = document.getElementById('modalNama');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        let currentFormId = null;

        function showModal(nama, formId) {
            modalNama.textContent = nama;
            currentFormId = formId;
            modal.style.display = 'flex';
            setTimeout(() => {
                modalContent.style.transform = 'scale(1)';
                modalContent.style.opacity = '1';
            }, 10);
            setTimeout(() => cancelBtn.focus(), 150);
        }

        function hideModal() {
            modalContent.style.transform = 'scale(0.95)';
            modalContent.style.opacity = '0';
            setTimeout(() => {
                modal.style.display = 'none';
                currentFormId = null;
            }, 300);
        }

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const nama = this.dataset.nama;
                const formId = this.dataset.formId;
                if (formId) showModal(nama, formId);
            });
        });

        cancelBtn.addEventListener('click', function() {
            const nama = modalNama.textContent;
            hideModal();
            showCancelToast('Penghapusan pelanggan "' + nama + '" dibatalkan');
        });

        confirmBtn.addEventListener('click', function() {
            if (currentFormId) {
                const form = document.getElementById(currentFormId);
                if (form) form.submit();
            }
            hideModal();
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                const nama = modalNama.textContent;
                hideModal();
                showCancelToast('Penghapusan pelanggan "' + nama + '" dibatalkan');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display === 'flex') {
                const nama = modalNama.textContent;
                hideModal();
                showCancelToast('Penghapusan pelanggan "' + nama + '" dibatalkan');
            }
        });
    })();
</script>
@endsection