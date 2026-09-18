@extends('layouts.admin')

@section('title', 'Edit Titik Kumpul')
@section('page_title', 'Edit Titik Kumpul')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 350px;
        width: 100%;
        border-radius: 8px;
        border: 2px solid #d1d5db;
        margin-top: 8px;
    }
    .form-input:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15) !important;
    }
    .search-results {
        position: absolute;
        z-index: 9999;
        background: white;
        border: 2px solid #d1d5db;
        border-radius: 8px;
        max-height: 220px;
        overflow-y: auto;
        width: 100%;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        display: none;
        margin-top: 4px;
    }
    .search-results .result-item {
        padding: 10px 14px;
        cursor: pointer;
        border-bottom: 1px solid #f3f4f6;
        font-size: 13px;
        color: #374151;
        line-height: 1.4;
    }
    .search-results .result-item:last-child { border-bottom: none; }
    .search-results .result-item:hover {
        background-color: #f0fdf4;
        color: #15803d;
    }
    .search-results .result-item.loading {
        text-align: center;
        color: #9ca3af;
        cursor: default;
        font-style: italic;
    }
    .search-results .result-item.loading:hover {
        background: #fff;
        color: #9ca3af;
    }
    .search-results .result-item.empty {
        text-align: center;
        color: #9ca3af;
        cursor: default;
        font-style: italic;
    }
    .search-results .result-item.empty:hover {
        background: #fff;
        color: #9ca3af;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px; font-weight:700; color:#1f2937; margin:0;">Edit Titik Kumpul</h1>
            <p style="font-size:14px; color:#6b7280; margin:4px 0 0 0;">Ubah data titik kumpul yang sudah ada</p>
        </div>
        <a href="{{ route('admin.titik-kumpul.index') }}" 
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

    <form action="{{ route('admin.titik-kumpul.update', $titikKumpul->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden;">

            {{-- HEADER FORM --}}
            <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Detail Titik Kumpul</h3>
                <span style="font-size:11px; font-weight:600; color:#6b7280; background:#e5e7eb; padding:4px 10px; border-radius:6px;">
                    ID: #{{ $titikKumpul->id }}
                </span>
            </div>

            <div style="padding:20px;">

                {{-- NAMA --}}
                <div style="margin-bottom:20px;">
                    <label for="nama" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Nama <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $titikKumpul->nama) }}" required
                           placeholder="Contoh: Kantor Pusat"
                           class="form-input"
                           style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                    @error('nama')
                        <p style="color:#dc2626; font-size:12px; margin:4px 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ALAMAT --}}
                <div style="margin-bottom:20px;">
                    <label for="alamat" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Alamat
                    </label>
                    <div style="position:relative;">
                        <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $titikKumpul->alamat) }}"
                               placeholder="Cari alamat... (contoh: Jakarta)"
                               autocomplete="off"
                               class="form-input"
                               style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                        <div id="searchResults" class="search-results"></div>
                    </div>
                    @error('alamat')
                        <p style="color:#dc2626; font-size:12px; margin:4px 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- MAP --}}
                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Lokasi di Peta
                    </label>
                    <div id="map"></div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:12px;">
                        <div>
                            <label style="display:block; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.3px; margin-bottom:4px;">
                                Latitude
                            </label>
                            <input type="text" id="latitude" name="latitude"
                                   value="{{ old('latitude', $titikKumpul->latitude ?? '-6.2088') }}"
                                   readonly
                                   style="width:100%; padding:8px 12px; border:2px solid #d1d5db; border-radius:8px; font-size:13px; font-weight:600; color:#4b5563; background:#f3f4f6; outline:none; box-sizing:border-box; cursor:not-allowed;">
                        </div>
                        <div>
                            <label style="display:block; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.3px; margin-bottom:4px;">
                                Longitude
                            </label>
                            <input type="text" id="longitude" name="longitude"
                                   value="{{ old('longitude', $titikKumpul->longitude ?? '106.8456') }}"
                                   readonly
                                   style="width:100%; padding:8px 12px; border:2px solid #d1d5db; border-radius:8px; font-size:13px; font-weight:600; color:#4b5563; background:#f3f4f6; outline:none; box-sizing:border-box; cursor:not-allowed;">
                        </div>
                    </div>

                    <div style="margin-top:8px; padding:10px 12px; background:#f0fdf4; border:2px solid #bbf7d0; border-radius:8px; display:flex; align-items:flex-start; gap:8px;">
                        <svg style="width:16px; height:16px; color:#15803d; flex-shrink:0; margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p style="font-size:12px; color:#15803d; margin:0; line-height:1.5;">
                            <strong>Tips:</strong> Klik peta atau geser marker untuk menentukan lokasi. Cari alamat di kotak pencarian untuk auto-locate.
                        </p>
                    </div>
                </div>

                {{-- KONTAK --}}
                <div style="margin-bottom:20px;">
                    <label for="kontak" style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Kontak <span style="color:#9ca3af; font-weight:500; text-transform:none;">(Opsional)</span>
                    </label>
                    <input type="text" id="kontak" name="kontak" value="{{ old('kontak', $titikKumpul->kontak) }}"
                           placeholder="Contoh: 08XXXXXXXXXX"
                           class="form-input"
                           style="width:100%; padding:12px 16px; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:500; color:#1f2937; background:#fff; outline:none; box-sizing:border-box;">
                    @error('kontak')
                        <p style="color:#dc2626; font-size:12px; margin:4px 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- STATUS --}}
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                        Status
                    </label>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <label style="cursor:pointer; display:block; position:relative;">
                            <input type="radio" name="is_active" value="1"
                                   {{ old('is_active', $titikKumpul->is_active) == 1 ? 'checked' : '' }}
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
                                   {{ old('is_active', $titikKumpul->is_active) == 0 ? 'checked' : '' }}
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
                <a href="{{ route('admin.titik-kumpul.index') }}"
                   style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                    Batal
                </a>
                <button type="submit"
                        style="display:inline-flex; align-items:center; justify-content:center; padding:10px 24px; background:#2563eb; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer;">
                    <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Titik Kumpul
                </button>
            </div>

        </div>
    </form>
</div>

{{-- STYLE UNTUK STATUS CARD --}}
<style>
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
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const defaultLat = parseFloat(document.getElementById('latitude').value) || -6.2088;
        const defaultLng = parseFloat(document.getElementById('longitude').value) || 106.8456;
        const center = [defaultLat, defaultLng];

        const map = L.map('map').setView(center, 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const marker = L.marker(center, { draggable: true }).addTo(map);

        marker.on('dragend', function() {
            const pos = marker.getLatLng();
            document.getElementById('latitude').value = pos.lat.toFixed(8);
            document.getElementById('longitude').value = pos.lng.toFixed(8);
        });

        map.on('click', function(e) {
            const pos = e.latlng;
            marker.setLatLng(pos);
            document.getElementById('latitude').value = pos.lat.toFixed(8);
            document.getElementById('longitude').value = pos.lng.toFixed(8);
        });

        const input = document.getElementById('alamat');
        const resultsContainer = document.getElementById('searchResults');
        let searchTimeout;

        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            if (query.length < 3) {
                resultsContainer.style.display = 'none';
                return;
            }

            // Loading state
            resultsContainer.innerHTML = '<div class="result-item loading">Mencari lokasi...</div>';
            resultsContainer.style.display = 'block';

            searchTimeout = setTimeout(function() {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5`)
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';
                        if (data.length === 0) {
                            resultsContainer.innerHTML = '<div class="result-item empty">Lokasi tidak ditemukan</div>';
                            return;
                        }
                        data.forEach(function(item) {
                            const div = document.createElement('div');
                            div.className = 'result-item';
                            div.textContent = item.display_name;
                            div.addEventListener('click', function() {
                                const lat = parseFloat(item.lat);
                                const lng = parseFloat(item.lon);
                                const newCenter = [lat, lng];
                                map.setView(newCenter, 15);
                                marker.setLatLng(newCenter);
                                document.getElementById('latitude').value = lat.toFixed(8);
                                document.getElementById('longitude').value = lng.toFixed(8);
                                document.getElementById('alamat').value = item.display_name;
                                resultsContainer.style.display = 'none';
                            });
                            resultsContainer.appendChild(div);
                        });
                        resultsContainer.style.display = 'block';
                    })
                    .catch(function() {
                        resultsContainer.innerHTML = '<div class="result-item empty">Gagal mencari lokasi</div>';
                    });
            }, 500);
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('div[style*="position:relative"]')) {
                resultsContainer.style.display = 'none';
            }
        });
    });
</script>
@endpush