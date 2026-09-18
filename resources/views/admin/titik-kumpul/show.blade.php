@extends('layouts.admin')

@section('title', 'Detail Titik Kumpul')
@section('page_title', 'Detail Titik Kumpul')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #miniMap {
        height: 300px;
        width: 100%;
        border-radius: 8px;
        border: 2px solid #d1d5db;
        margin-top: 8px;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px; font-weight:700; color:#1f2937; margin:0;">Detail Titik Kumpul</h1>
            <p style="font-size:14px; color:#6b7280; margin:4px 0 0 0;">Informasi lengkap titik kumpul</p>
        </div>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('admin.titik-kumpul.edit', $titikKumpul->id) }}" 
               style="display:inline-flex; align-items:center; padding:10px 20px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none; transition:all 0.2s;">
                <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.titik-kumpul.index') }}" 
               style="display:inline-flex; align-items:center; padding:10px 20px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none; transition:all 0.2s;">
                <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- CARD DETAIL --}}
    <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden;">

        {{-- HEADER FORM --}}
        <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <svg style="width:20px; height:20px; color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Informasi Titik Kumpul</h3>
            </div>
            <span style="font-size:11px; font-weight:600; color:#6b7280; background:#e5e7eb; padding:4px 10px; border-radius:6px;">
                ID: #{{ $titikKumpul->id }}
            </span>
        </div>

        <div style="padding:20px;">

            {{-- STATUS BANNER --}}
            <div style="margin-bottom:20px; padding:12px 16px; border-radius:8px; border:2px solid {{ $titikKumpul->is_active ? '#bbf7d0' : '#fecaca' }}; background: {{ $titikKumpul->is_active ? '#f0fdf4' : '#fef2f2' }}; display:flex; align-items:center; gap:10px;">
                @if($titikKumpul->is_active)
                    <svg style="width:20px; height:20px; color:#15803d; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p style="font-size:14px; font-weight:700; color:#15803d; margin:0;">Titik Kumpul Aktif</p>
                        <p style="font-size:12px; color:#166534; margin:2px 0 0 0;">Titik kumpul ini sedang aktif dan bisa digunakan user.</p>
                    </div>
                @else
                    <svg style="width:20px; height:20px; color:#b91c1c; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    <div>
                        <p style="font-size:14px; font-weight:700; color:#b91c1c; margin:0;">Titik Kumpul Nonaktif</p>
                        <p style="font-size:12px; color:#991b1b; margin:2px 0 0 0;">Titik kumpul ini sedang tidak aktif.</p>
                    </div>
                @endif
            </div>

            {{-- GRID INFO --}}
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:16px; margin-bottom:20px;">

                {{-- Nama --}}
                <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                    <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                        <svg style="width:14px; height:14px; color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Nama</p>
                    </div>
                    <p style="font-size:15px; font-weight:700; color:#1f2937; margin:0;">{{ $titikKumpul->nama }}</p>
                </div>

                {{-- Kontak --}}
                <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                    <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                        <svg style="width:14px; height:14px; color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Kontak</p>
                    </div>
                    @if($titikKumpul->kontak)
                        <a href="tel:{{ $titikKumpul->kontak }}" style="font-size:15px; font-weight:700; color:#16a34a; margin:0; text-decoration:none;">
                            {{ $titikKumpul->kontak }}
                        </a>
                    @else
                        <p style="font-size:15px; font-weight:500; color:#9ca3af; margin:0; font-style:italic;">Belum diisi</p>
                    @endif
                </div>

                {{-- Latitude --}}
                <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                    <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                        <svg style="width:14px; height:14px; color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Latitude</p>
                    </div>
                    <p style="font-size:15px; font-weight:700; color:#1f2937; margin:0; font-family:monospace;">{{ $titikKumpul->latitude ?: '-' }}</p>
                </div>

                {{-- Longitude --}}
                <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                    <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                        <svg style="width:14px; height:14px; color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Longitude</p>
                    </div>
                    <p style="font-size:15px; font-weight:700; color:#1f2937; margin:0; font-family:monospace;">{{ $titikKumpul->longitude ?: '-' }}</p>
                </div>

                {{-- Alamat --}}
                <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb; grid-column: 1 / -1;">
                    <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                        <svg style="width:14px; height:14px; color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Alamat Lengkap</p>
                    </div>
                    @if($titikKumpul->alamat)
                        <p style="font-size:14px; font-weight:500; color:#1f2937; margin:0; line-height:1.6;">{{ $titikKumpul->alamat }}</p>
                    @else
                        <p style="font-size:14px; font-weight:500; color:#9ca3af; margin:0; font-style:italic;">Belum diisi</p>
                    @endif
                </div>

            </div>

            {{-- MINI MAP PREVIEW --}}
            @if($titikKumpul->latitude && $titikKumpul->longitude)
                <div style="margin-bottom:20px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; margin-bottom:8px;">
                        <label style="font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0;">
                            Preview Lokasi
                        </label>
                        <a href="https://www.google.com/maps?q={{ $titikKumpul->latitude }},{{ $titikKumpul->longitude }}" 
                           target="_blank"
                           style="display:inline-flex; align-items:center; gap:4px; font-size:12px; color:#16a34a; font-weight:700; text-decoration:none;">
                            <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            Buka di Google Maps
                        </a>
                    </div>
                    <div id="miniMap"></div>
                </div>
            @endif

        </div>

        {{-- ACTION BUTTONS --}}
        <div style="padding:16px 20px; background:#f9fafb; border-top:2px solid #e5e7eb; display:flex; flex-wrap:wrap; gap:12px; justify-content:space-between; align-items:center;">
            <p style="font-size:12px; color:#6b7280; margin:0;">
                <svg style="width:14px; height:14px; display:inline; vertical-align:middle; margin-right:4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Terakhir diperbarui: {{ $titikKumpul->updated_at ? $titikKumpul->updated_at->format('d M Y, H:i') : '-' }}
            </p>
            <div style="display:flex; gap:12px;">
                <a href="{{ route('admin.titik-kumpul.index') }}"
                   style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                    Kembali
                </a>
                <a href="{{ route('admin.titik-kumpul.edit', $titikKumpul->id) }}"
                   style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                    <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Titik Kumpul
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
@if($titikKumpul->latitude && $titikKumpul->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lat = parseFloat({{ $titikKumpul->latitude }});
        const lng = parseFloat({{ $titikKumpul->longitude }});
        const center = [lat, lng];

        const map = L.map('miniMap', {
            zoomControl: true,
            scrollWheelZoom: false
        }).setView(center, 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        L.marker(center).addTo(map)
            .bindPopup('<strong>{{ $titikKumpul->nama }}</strong><br>{{ $titikKumpul->alamat ?: "" }}')
            .openPopup();

        // Circle marker untuk highlight area
        L.circle(center, {
            color: '#16a34a',
            fillColor: '#16a34a',
            fillOpacity: 0.1,
            radius: 100
        }).addTo(map);
    });
</script>
@endif
@endpush